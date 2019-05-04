<?php
/**
 * Checkout.com Magento 2 Payment module (https://www.checkout.com)
 *
 * Copyright (c) 2017 Checkout.com (https://www.checkout.com)
 * Author: David Fiaty | integration@checkout.com
 *
 * MIT License
 */

namespace CheckoutCom\Magento2\Observer\Backend;

use Magento\Framework\Event\Observer;

class OrderSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var BackendAuthSession
     */
    protected $backendAuthSession;

    /**
     * OrderSaveBefore constructor.
     */
    public function __construct(
        \Magento\Backend\Model\Auth\Session $backendAuthSession
    ) {
        $this->backendAuthSession    = $backendAuthSession;
    }
 
    /**
     * Observer execute function.
     */
    public function execute(Observer $observer)
    {
        // Get the order
        $order = $observer->getEvent()->getOrder();

        // Get the method id
        $methodId = $order->getPayment()->getMethodInstance()->getCode();

        if ($this->backendAuthSession->isLoggedIn() && $methodId == 'checkoutcom_moto') {



        }
        
        return $this;
    }
}
