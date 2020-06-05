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

namespace CheckoutCom\Magento2\Controller\Adminhtml\LogReader\Data;

use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    public $resultJsonFactory;

    /**
     * @var View
     */
    public $viewHelper;

    /**
     * Index class constructor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Naxero\Translation\Helper\View $viewHelper
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->viewHelper = $viewHelper;

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
        $output = [];

        // Process the request
        if ($this->getRequest()->isAjax()) {
            // Get the view mode
            $view = $this->getRequest()->getParam('view');

            // Render the view
            $output = $this->viewHelper->render($view);
        }

        return $this->resultJsonFactory->create()->setData($output);
    }
}
