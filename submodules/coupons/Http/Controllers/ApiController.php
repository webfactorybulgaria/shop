<?php

namespace TypiCMS\Modules\Coupons\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Coupons\Shells\Models\Coupon;
use TypiCMS\Modules\Coupons\Shells\Repositories\CouponInterface as Repository;
use TypiCMS\Modules\Coupons\Shells\Http\Requests\PublicRequest;
use TypiCMS\Modules\Shop\Shells\Models\Cart;
use Carbon\Carbon;

class ApiController extends BaseApiController
{

    /**
     *  Array of endpoints that do not require authorization
     *  
     */
    protected $publicEndpoints = ['process', 'remove'];

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $model = $this->repository->create(Request::all());
        $error = $model ? false : true;

        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $updated = $this->repository->update(Request::all());

        return response()->json([
            'error' => !$updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Coupons\Shells\Models\Coupon $coupon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Coupon $coupon)
    {
        $deleted = $this->repository->delete($coupon);

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    /**
     * Add coupon code
     *
     * @return \Illuminate\View\View
     */
    public function process(PublicRequest $request)
    {
        $promocode = $this->repository->getFirstBy('code', $request->coupon);

        $cart = Cart::current();

        if($promocode) {
            if (!Carbon::now()->between(Carbon::parse($promocode->starts_at), Carbon::parse($promocode->expires_at)) || $promocode->total_available == 0) {
                $promocode->expired = true;
            }
            elseif ($promocode->value > 0 && $promocode->value > $cart->totalPrice) {
                $promocode->overlimit = true;
            }
            else {
                $cart->setCoupon($promocode);
                $cart = Cart::current();
            }
        }
        return response()->json([
            'promocode' => $promocode,
            'discount' => $cart->displayTotalDiscount,
            'price' => $cart->displayTotalPrice,
            'total' => $cart->displayTotal
        ]);
    }

    /**
     * Remove coupon code
     *
     * @return \Illuminate\View\View
     */
    public function remove()
    {
        $cart = Cart::current();

        session()->forget('coupon');
        if (is_null(session('coupon'))) {
            return response()->json([
                'removed' => true,
                'discount' => $cart->displayTotalDiscount,
                'price' => $cart->displayTotalPrice,
                'total' => $cart->displayTotal
            ]);
        }
    }
}
