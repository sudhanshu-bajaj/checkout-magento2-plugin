<?php


namespace CheckoutCom\Magento2\Model\Methods;

use CheckoutCom\Magento2\Gateway\Config\Config;

class CardMethod extends Method
{

    /**
     * @var string
     * @overriden
     */
    protected $_code = Config::CODE_CARD;

}
