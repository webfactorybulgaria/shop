<?php

namespace TypiCMS\Modules\Orders\Models;

use Amsgames\LaravelShop\Models\ShopOrderModel;
use TypiCMS\Modules\Orders\Shells\Models\OrderAddress;

class Order extends ShopOrderModel
{
	protected $appends = ['displayTotalPrice', 'displayTotal'];

    public function shippingAddress()
    {
        return $this->belongsTo(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->belongsTo(OrderAddress::class);
    }

    public function setCouponId($coupon_id)
    {
        $this->coupon_id = $coupon_id;
        return $this;
    }

    public function setAddresses($shippingAddress, $billingAddress)
    {

        if ($shippingAddress) {
            $arrShippingAddress = $shippingAddress->toArray();
            $arrShippingAddress['user_address_id'] = $arrShippingAddress['id'];
            $arrShippingAddress['order_id'] = $this->id;
            unset($arrShippingAddress['id']);
            $orderShippingAddress = OrderAddress::create($arrShippingAddress);
            $this->shipping_address_id = $orderShippingAddress->id;
        }

        if ($billingAddress) {
            if ($shippingAddress && $billingAddress->id == $shippingAddress->id) {
                $orderBillingAddress = $orderShippingAddress;
            } else {
                $arrBillingAddress = $billingAddress->toArray();
                $arrBillingAddress['user_address_id'] = $arrBillingAddress['id'];
                $arrBillingAddress['order_id'] = $this->id;
                unset($arrBillingAddress['id']);
                $orderBillingAddress = OrderAddress::create($arrBillingAddress);
            }
            $this->billing_address_id = $orderBillingAddress->id;
        }

        return $this;
    }

    // You can override the shipping price calculation here:
    public function getTotalShippingAttribute()
    {
        return $this->shipping ?: 0;
    }
}
