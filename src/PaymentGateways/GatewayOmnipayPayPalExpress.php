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

class GatewayOmnipayPayPalExpress extends GatewayOmnipay
{
    protected function getCompleteParams($order, $data)
    {
        // dd($data);
        $token  = is_array($data) ? $data['token'] : $data->token;

        return [
            'transactionReference' => $token, // always return transactionReference
            'transactionId' => $order->id,
            'transactionReference' => $token,
            'amount' => $order->total,
            'currency' => Config::get('shop.currency'),
        ];
    }

    /**
     * Setups contexts for api calls.
     */
    protected function setContext()
    {
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(Config::get('services.paypal.username'));
        $gateway->setPassword(Config::get('services.paypal.password'));
        $gateway->setSignature(Config::get('services.paypal.signature'));
        $gateway->setTestMode(Config::get('services.paypal.sandbox'));
// dd($gateway->getParameters());

        $this->apiContext = $gateway;
    }

}