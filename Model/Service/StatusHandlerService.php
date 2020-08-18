<?php
/**
 * Checkout.com
 * Authorized and regulated as an electronic money institution
 * by the UK Financial Conduct Authority (FCA) under number 900816.
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Checkout.com
 * @author    Platforms Development Team <platforms@checkout.com>
 * @copyright 2010-2019 Checkout.com
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://docs.checkout.com/
 */

namespace CheckoutCom\Magento2\Model\Service;

use Magento\Sales\Model\Order\Payment\Transaction;

/**
 * Class StatusHandlerService.
 */
class StatusHandlerService
{
    /**
     * @var \Magento\Sales\Model\Order
     */
    public $orderModel;

    /**
     * @var Utilities
     */
    public $utilities;

    /**
     * @var WebhookHandlerService
     */
    public $webhookHandler;

    /**
     * @var TransactionHandlerService
     */
    public $transactionHandler;

    /**
     * @var Registry
     */
    public $registry;

    /**
     * @var OrderRepositoryInterface
     */
    public $orderRepository;

    /**
     * @var StoreManagerInterface
     */
    public $storeManager;
    /**
     * @var Config
     */
    public $config;
    /**
     * StatusHandlerService constructor.
     */
    public function __construct(
        \Magento\Sales\Model\Order $orderModel,
        \CheckoutCom\Magento2\Helper\Utilities $utilities,
        \CheckoutCom\Magento2\Model\Service\WebhookHandlerService $webhookHandler,
        \CheckoutCom\Magento2\Model\Service\TransactionHandlerService $transactionHandler,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \CheckoutCom\Magento2\Gateway\Config\Config $config
    ) {
        $this->orderModel            = $orderModel;
        $this->utilities             = $utilities;
        $this->webhookHandler        = $webhookHandler;
        $this->transactionHandler    = $transactionHandler;
        $this->registry              = $registry;
        $this->orderRepository       = $orderRepository;
        $this->storeManager          = $storeManager;
        $this->config                = $config;
    }

    /**
     * @param $order
     * @param $transaction
     * @param $amount
     * @param $payload
     *
     * Set order status from webhook or transaction
     */
    public function setOrderStatus($order, $transaction, $amount, $payload) {
        // Get the event type
        if ($transaction) {
            $type = $transaction->getTxnType();
        } else {
            $type = $payload->type;
        }

        // Get the store code
        $storeCode = $this->storeManager->getStore()->getCode();

        // Initialise state and status
        $state = null;
        $status = null;

        // Get the needed order status
        switch ($type) {
            case Transaction::TYPE_AUTH:
                if ($order->getState() !== 'processing') {
                    $status = $this->config->getValue('order_status_authorized');
                }
                // Flag order if potential fraud
                if ($this->isFlagged($payload)) {
                    $status = $this->config->getValue('order_status_flagged');
                }
                break;

            case Transaction::TYPE_CAPTURE:
                $status = $this->config->getValue('order_status_captured');
                $state = $this->orderModel::STATE_PROCESSING;
                break;

            case Transaction::TYPE_VOID:
                $status = $this->config->getValue('order_status_voided');
                $state = $this->orderModel::STATE_CANCELED;
                break;

            case Transaction::TYPE_REFUND:
                $isPartialRefund = $this->transactionHandler->isPartialRefund(
                    $transaction,
                    $amount,
                    true
                );
                $status = $isPartialRefund ? 'order_status_captured' : 'order_status_refunded';
                $status = $this->config->getValue($status);
                $state = $isPartialRefund ? $this->orderModel::STATE_PROCESSING : $this->orderModel::STATE_CLOSED;
                break;

            case 'payment_capture_pending':
                if (isset($payload->data->metadata->methodId)
                    && $payload->data->metadata->methodId === 'checkoutcom_apm'
                ) {
                    $state = $this->orderModel::STATE_PENDING_PAYMENT;
                    $status = $order->getConfig()->getStateDefaultStatus($state);
                    $order->addStatusHistoryComment(__('Payment capture initiated, awaiting capture confirmation.'));
                }
                break;

            case 'payment_expired':
                $this->handleFailedPayment($order, $storeCode, $payload-$type);
                break;
        }

        if ($state) {
            // Set the order state
            $order->setState($state);
        }

        if ($status) {
            // Set the order status
            $order->setStatus($status);
        }

        // Save the order
        $order->save();
    }

    /**
     * Sets status/deletes order based on user config if payment fails
     */
    public function handleFailedPayment($order, $storeId, $webhook = false)
    {
        $failedWebhooks = [
            "payment_declined",
            "payment_expired",
            "payment_cancelled",
            "payment_voided",
            "payment_capture_declined"
        ];

        if (!$webhook || in_array($webhook, $failedWebhooks)) {
            // Get config for failed payments
            $config = $this->config->getValue('order_action_failed_payment', null, $storeId);

            if ($config == 'cancel' || $config == 'delete') {
                $this->cancelOrder($order);

                if ($config == 'delete') {
                    $this->deleteOrder($order);
                }
            }
        }
    }

    /**
     * @param $payload
     * @return bool
     * Check if payment has been flagged for potential fraud
     */
    public function isFlagged($payload) {
        return isset($payload->data->risk->flagged)
            && $payload->data->risk->flagged == true;
    }

    /**
     * @param $order
     * Cancel order and set status to config value
     */
    public function cancelOrder($order) {
        $this->orderModel->loadByIncrementId($order->getIncrementId())->cancel();
        $order->setStatus($this->config->getValue('order_status_canceled'));
        $order->setState($this->orderModel::STATE_CANCELED);
        $order->save();
    }

    /**
     * @param $order
     * Delete order from database
     */
    public function deleteOrder($order) {
        $this->registry->register('isSecureArea', true);
        $this->orderRepository->delete($order);
        $this->registry->unregister('isSecureArea');
    }
}
