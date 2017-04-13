<?php

namespace TypiCMS\Modules\Shop\PaymentGateways;

/**
 * Gateway that adds Omnipay payments to Laravel Shop.
 *
 * @author Atanas Georgiev
 * @copyright Webfactory Bulgaria
 * @license MIT
 * @package webfactorybulgaria\laravelshop
 */

use Omnipay\Omnipay;
use Illuminate\Support\Facades\Config;

class GatewayOmnipayPayPalRest extends GatewayOmnipay
{
    protected function getCompleteParams($order, $data)
    {
        $paymentId  = is_array($data) ? $data['paymentId'] : $data->paymentId;
        $payerId    = is_array($data) ? $data['PayerID'] : $data->PayerID;

        return [
            'transactionReference' => $paymentId, // always return transactionReference
            'payerId' => $payerId
        ];
    }

    /**
     * Setups contexts for api calls.
     */
    protected function setContext()
    {
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId(Config::get('services.paypal.client_id'));
        $gateway->setSecret(Config::get('services.paypal.secret'));
        $gateway->setTestMode(Config::get('services.paypal.sandbox'));

        $this->apiContext = $gateway;
    }

}