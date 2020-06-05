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

namespace CheckoutCom\Magento2\Controller\Adminhtml\LogReader\Cache;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    public $resultJsonFactory;

    /**
     * @var Data
     */
    public $helper;

    /**
     * Index class constructor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Naxero\Translation\Helper\Data $helper
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;

        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\Result\JsonFactory
     */
    public function execute()
    {
        // Prepare the output array
        $output = [
            'success' => true,
            'message' => __('The cache has been cleared successfully.')
        ];

        // Get the view mode
        $action = $this->getRequest()->getParam('action');

        // Process the request
        if ($this->getRequest()->isAjax() && $action == 'flush_cache') {
            try {
                $this->helper->flushCache();
            } catch (\Exception $e) {
                $output = [
                    'success' => false,
                    'message' => __($e->getMessage())
                ];
            }
        } else {
            $output = [
                'success' => false,
                'message' => __('This request is not allowed. Please check your code and server settings.')
            ];
        }

        return $this->resultJsonFactory->create()->setData($output);
    }
}
