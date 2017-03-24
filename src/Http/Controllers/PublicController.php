<?php

namespace TypiCMS\Modules\Shop\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BasePublicController;
use Auth;
use Shop;
use TypiCMS\Modules\Orders\Shells\Models\Order;
use TypiCMS\Modules\Shop\Shells\Models\Cart;
use TypiCMS\Modules\Shop\Shells\Models\Item;
use TypiCMS\Modules\Coupons\Models\Coupon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use DB;

class PublicController extends BasePublicController
{
    /**
     * Show all items in user's basket.
     *
     * @return \Illuminate\View\View
     */
    public function basket()
    {
        $cart = Cart::current();

        return view('shop::public.basket')
            ->with(compact('cart'));
    }

    /**
     * Increase item quantity in user's basket.
     *
     * @return \Illuminate\View\View
     */
    public function increaseItem($itemId, $quantity)
    {
        $item = Item::find($itemId);

        $cart = Cart::current();

        if ($item->cart_id == $cart->id) // check if the item belongs to the current cart
            $cart->increase($item, $quantity);

        return redirect()->back();
    }

    /**
     * Remove item from user's basket.
     *
     * @return \Illuminate\View\View
     */
    public function removeItem($itemId, $quantity = null)
    {
        $item = Item::find($itemId);

        $cart = Cart::current();

        if ($item->cart_id == $cart->id) // check if the item belongs to the current cart
            $cart->remove($item, $quantity);

        return redirect()->back();
    }

    /**
     * Checkout.
     *
     * @return \Illuminate\View\View
     */
    public function checkout()
    {
        $cart = Cart::current();
        $user = Auth::user();

        if(session('coupon')) {
            app('JavaScript')->put('promocode', session('coupon'));
        }

        return view('shop::public.checkout')
            ->with(compact('cart', 'user'));
    }

    /**
     * Purchase.
     *
     * @return \Illuminate\View\View
     */
    public function purchase()
    {
        if(Auth::check()) {
            Shop::setGateway('paypalExpress');
            if (!Shop::checkout()) {
                echo Shop::exception()->getMessage(); // card validation error.
            } else {
                $order = Shop::placeOrder(Cart::current());

                if ($order->hasFailed) {
                    dd(Shop::exception());
                    echo Shop::exception()->getMessage(); // payment error.
                }

                if ($order->isPending || $order->isCompleted) {
                    // PayPal URL to redirect to proceed with payment
                    $approvalUrl = Shop::gateway()->getApprovalUrl();

                    // Redirect to url
                    return redirect($approvalUrl);
                }
            }
        }
        /*TODO: handle error state*/
    }

    /**
     * Confirmation page.
     *
     * @return \Illuminate\View\View
     */
    public function confirmation()
    {
        $order = Order::find(Input::get('order'));
        $discount = '';
        /*
        //update coupon's total available value
        if (!is_null(session('coupon'))) {
            Coupon::where('id', session('coupon')->id)->decrement('total_available', 1);
            DB::table(Config::get('shop.item_table'))
                ->insert([
                    'user_id' => Auth::user()->id,
                    'session_id' => session('visitor_id'),
                    'cart_id' => null, 
                    'order_id' => $order->id,
                    'sku' => session('coupon')->sku,
                    'tax' => 0,
                    'shipping' => 0,
                    'discount' => 0,
                    'price' => 0 - $order->totalDiscount,
                    'currency' => Config::get('shop.currency'),
                    'quantity' => 1,
                    'class' => 'TypiCMS\Modules\Products\Shells\Models\Product'
                ]);
            $discount = session('coupon')->value;
            session()->forget('coupon');
        }
        */

        return view('shop::public.confirmation')->with(compact('order', 'discount'));
    }
}
