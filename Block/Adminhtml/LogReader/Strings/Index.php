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

namespace CheckoutCom\Magento2\Block\Adminhtml\LogReader\Strings;

class Index extends \Magento\Backend\Block\Template
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * Index class constructor.
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Naxero\Translation\Helper\Data $helper
    ) {
        parent::__construct($context);
        $this->helper = $helper;
    }

    /**
     * Prepare the block layout.
     */
    public function _prepareLayout()
    {
       // Set page title
        $this->pageConfig->getTitle()->set(__('Language strings'));

        return parent::_prepareLayout();
    }
}
