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

define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'CheckoutCom_Magento2/js/view/payment/utilities',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magento_Checkout/js/action/redirect-on-success',
        'mage/translate',
        'paypaljs'
    ],
    function ($, Component, Utilities, FullScreenLoader, AdditionalValidators, RedirectOnSuccessAction, __, PayPal) {
        'use strict';
        window.checkoutConfig.reloadOnBillingAddress = true;
        const METHOD_ID = 'checkoutcom_paypal';
        let checkoutConfig = window.checkoutConfig.payment["checkoutcom_magento2"];

        return Component.extend(
            {
                defaults: {
                    template: 'CheckoutCom_Magento2/payment/' + METHOD_ID + '.html',
                    button_target: 'ckoPaypalButton',
                    redirectAfterPlaceOrder: false
                },

                /**
                 * @return {exports}
                 */
                initialize: function () {
                    this._super();
                    Utilities.setEmail();
                    Utilities.loadCss('paypal', 'paypal');

                    return this;
                },

                /**
                 * Methods
                 */

                /**
                 * @return {string}
                 */
                getCode: function () {
                    return METHOD_ID;
                },

                /**
                 * @return {string}
                 */
                getValue: function (field) {
                    return Utilities.getValue(METHOD_ID, field);
                },

                /**
                 * @return {void}
                 */
                checkDefaultEnabled: function () {
                    return Utilities.checkDefaultEnabled(METHOD_ID);
                },

                /**
                 * @return {bool}
                 */
                launchPayPal: function () {
                    // Prepare the parameters
                    var self = this;

                    paypal.Button.render({
                    style: {
                        size: 'responsive',
                        color: checkoutConfig["checkoutcom_paypal"]["button_color"],
                        shape: checkoutConfig["checkoutcom_paypal"]["button_shape"],
                        tagline: checkoutConfig["checkoutcom_paypal"]["button_tagline"]
                    }
                    }, self.button_target);

                    //  Button click event
                    $(self.button_target).click(
                        function (evt) {
                            if (Utilities.methodIsSelected(METHOD_ID)) {
                                // Validate T&C submission
                                if (!AdditionalValidators.validate()) {
                                    return;
                                }


                            }
                        }
                    );
                }
            }
        );
    }
);
