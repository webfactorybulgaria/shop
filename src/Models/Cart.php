<?php

namespace TypiCMS\Modules\Shop\Models;

use Auth;
use Amsgames\LaravelShop\Models\ShopCartModel;
use Illuminate\Support\Facades\Session;
use TypiCMS\Modules\Users\Shells\Models\UserAddress;

class Cart extends ShopCartModel
{

    public function shippingAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function billingAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function setAddresses($shipping_address, $billing_address = null)
    {
        $addresses = [];
        if (empty($shipping_address)) return false;

        if (empty($billing_address))
            $billing_address = $shipping_address;

        $addresses[] = (int)$shipping_address;
        $addresses[] = (int)$billing_address;

        $userAddresses = UserAddress::whereIn('id', $addresses)->where('user_id', Auth::user()->id)->get()->keyBy('id');

        if ( empty($userAddresses[$shipping_address]) || empty($userAddresses[$billing_address]) )
            return false;

        $this->shipping_address_id = $shipping_address;
        $this->billing_address_id = $billing_address;
        $this->save();

        return true;
    }

    public function placeOrder($statusCode = null)
    {
        // Store these before placing the order as it clears the calculations
        $calculations = [
            'base_price' => $this->totalPrice + $this->totalDiscount, // totalPrice has the discount subtracted already
            'tax' => $this->totalTax,
            'discount' => $this->totalDiscount,
            'shipping' => $this->totalShipping,
            'total' => $this->total,
        ];

        $order = parent::placeOrder($statusCode);
        $order->base_price = $calculations['base_price'];
        $order->tax = $calculations['tax'];
        $order->discount = $calculations['discount'];
        $order->shipping = $calculations['shipping'];
        $order->total = $calculations['total'];

        $order->setAddresses($this->shippingAddress, $this->billingAddress);
        $order->setCouponId($this->coupon_id);
        $order->save();

        return $order;
    }

    public function setCoupon($coupon)
    {
        parent::setCoupon($coupon);
        $this->coupon_id = $coupon->id;
        $this->save();
    }

    // You can override the shipping price calculation here:
    public function getTotalShippingAttribute()
    {
        return 11;
    }

}