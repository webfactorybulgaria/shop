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

use Amsgames\LaravelShop\Exceptions\CheckoutException;
use Amsgames\LaravelShop\Exceptions\GatewayException;
use Amsgames\LaravelShop\Exceptions\ShopException;
use Amsgames\LaravelShop\Core\PaymentGateway;
use Illuminate\Support\Facades\Config;

class GatewayOmnipay extends PaymentGateway
{
    /**
     * Gateway instance.
     * @var object
     */
    protected $gateway           = null;

    /**
     * PayPal's api context.
     * @var object
     */
    protected $apiContext;

    /**
     * Approval URL to redirect to.
     */
    protected $approvalUrl = '';

    /**
     * Returns paypal url for approval.
     *
     * @return string
     */
    public function getApprovalUrl()
    {
        return $this->approvalUrl;
    }

    protected function getPurchaseParams($order)
    {
        $params = array(
            'cancelUrl' => $this->callbackFail,
            'returnUrl' => $this->callbackSuccess,
            'amount' => $order->total,
            'currency' => Config::get('shop.currency')
        );

        return $params;
    }

    /**
     * Called by shop to charge order's amount.
     *
     * @param Cart $cart Cart.
     *
     * @return bool
     */
    public function onCharge($order)
    {
        $this->statusCode = 'pending';

        // Begin paypal
        try {
            if ($order->total <= 0) {

                $this->statusCode = 'completed';

                $this->detail = 'Order total is 0; no transaction required.';

                $this->transactionId = uniqid();

                return true;
            }

            $this->setContext();

            $params = getPurchaseParams($order);

            $response = $this->apiContext->purchase($params)->setItems($this->toItems($order))->send();

            $this->approvalUrl = $response->getRedirectUrl();

            $this->detail = sprintf('Pending approval: %s', $this->approvalUrl);

            return true;

        } catch (\Exception $e) {

            throw new GatewayException(
                $e->getMessage(),
                1000,
                $e
            );

        }

        return false;
    }

    protected function getCompleteParams($order, $data)
    {
        return [
            'transactionReference' => uniqid(), // always return transactionReference
        ];
    }

    /**
     * Called on callback.
     *
     * @param Order $order Order.
     * @param mixed $data  Request input from callback.
     *
     * @return bool
     */
    public function onCallbackSuccess($order, $data = null)
    {
        $completeParams = $this->getCompleteParams($order, $data);

        $this->statusCode = 'failed';

        $this->detail = sprintf('Payment failed. Ref: %s', $completeParams['transactionReference']);

        // Begin paypal
        try {

            $this->setContext();

            $response = $this->apiContext->completePurchase($completeParams)->send();

            if ($response->isSuccessful()) {
                $this->statusCode = 'completed';

                $this->transactionId = $response->getTransactionReference();

                $this->detail = 'Success';
            } else {
                throw new GatewayException(
                    sprintf(
                        '%s: %s',
                        $response->name,
                        isset($response->message) ? $response->message : 'Paypal payment Failed.'
                    ),
                    1001
                );
            }

        } catch (\Exception $e) {

            throw new GatewayException(
                $e->getMessage(),
                1000,
                $e
            );

        }
    }

    /**
     * Converts the items in the order into paypal items for purchase.
     *
     * @param object $order Order.
     *
     * @return array
     */
    private function toItems($order)
    {
        $items = [];

        foreach ($order->items as $shopItem) {
            if ($shopItem->price > 0) {
                $items[] = [
                    'name' => substr($shopItem->displayName, 0, 127),
                    'description' => $shopItem->sku,
                    'price' => $shopItem->price,
                    'quantity' => $shopItem->quantity
                ];
            }
        }
        if ($tax = $order->totalTax) {
            $items[] = [
                'name' => 'Tax',
                'description' => 'tax',
                'price' => $tax,
                'quantity' => 1
            ];
        }
        if ($shipping = $order->totalShipping) {
            $items[] = [
                'name' => 'Shipping',
                'description' => 'shipping',
                'price' => $shipping,
                'quantity' => 1
            ];
        }
        if ($discount = $order->totalDiscount) {
            $items[] = [
                'name' => 'Discount',
                'description' => 'discount',
                'price' => -$discount,
                'quantity' => 1
            ];
        }

        return $items;
    }
}