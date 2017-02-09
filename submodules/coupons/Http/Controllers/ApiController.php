<?php

namespace TypiCMS\Modules\Coupons\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Coupons\Shells\Models\Coupon;
use TypiCMS\Modules\Coupons\Shells\Repositories\CouponInterface as Repository;
use TypiCMS\Modules\Coupons\Shells\Http\Requests\PublicRequest;
use TypiCMS\Modules\Shop\Shells\Models\Cart;

class ApiController extends BaseApiController
{

    /**
     *  Array of endpoints that do not require authorization
     *  
     */
    protected $publicEndpoints = [];

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function process(PublicRequest $request)
    {
        $promocode = $this->repository->getFirstBy('code', $request->coupon);

        if($promocode) {
            $cart = Cart::current();
            $cart->setCoupon($promocode);
        }

        return response()->json([
            'promocode' => $promocode,
        ]);
    }
}
