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

namespace CheckoutCom\Magento2\Controller\Api;

use CheckoutCom\Magento2\Model\Service\CardHandlerService;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class setConfig
 */
class setConfig extends \Magento\Framework\App\Action\Action
{
    /**
     * @var JsonFactory
     */
    public $jsonFactory;

    /**
     * @var Config
     */
    public $config;

    /**
     * @var StoreManagerInterface
     */
    public $storeManager;

    /**
     * @var Utilities
     */
    public $utilities;

    /**
     * @var Array
     */
    public $data;

    /**
     * Callback constructor
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \CheckoutCom\Magento2\Gateway\Config\Config $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \CheckoutCom\Magento2\Helper\Utilities $utilities
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->config = $config;
        $this->storeManager = $storeManager;
        $this->utilities = $utilities;
    }

    /**
     * Handles the controller method.
     */
    public function execute()
    {
        try {
            // Set the response parameters
            $success = false;
            $orderId = 0;
            $errorMessage = '';

            // Get the request parameters
            $this->data = json_decode($this->getRequest()->getContent());

            // Validate the request
            if ($this->isValidRequest()) {
                $intendedConfigField = $this->data->config_field;
                $intendedConfigValue = $this->data->config_value;

                $this->config->setValue($intendedConfigField, $intendedConfigValue);
            } else {
                $errorMessage = __('The request is invalid.');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        } finally {
            // Return the json response
            return $this->jsonFactory->create()->setData([
                'success' => $success,
                'error_message' => $errorMessage
            ]);
        }
    }

    /**
     * Check if the request is valid.
     */
    public function isValidRequest()
    {
        return $this->config->isValidAuth('pk')
            && $this->dataIsValid();
    }

    /**
     * Check if the data is valid.
     */
    public function dataIsValid()
    {
        // Check the config key is set
        if ((!isset($this->data->config_field) && !isset($this->data['config_field']))) {
            throw new LocalizedException(
                __('The config key is missing.')
            );
        }

        // Check the config value is set
        if ((!isset($this->data->config_value) && !isset($this->data['config_value']))) {
            throw new LocalizedException(
                __('The config value is missing.')
            );
        }

        return true;
    }
}
