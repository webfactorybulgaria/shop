<?php

namespace TypiCMS\Modules\Coupons\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Coupons\Shells\Http\Requests\FormRequest;
use TypiCMS\Modules\Coupons\Shells\Models\Coupon;
use TypiCMS\Modules\Coupons\Shells\Repositories\CouponInterface;

class AdminController extends BaseAdminController
{
    public function __construct(CouponInterface $coupon)
    {
        parent::__construct($coupon);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('coupons::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('coupons::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Coupons\Shells\Models\Coupon $coupon
     *
     * @return \Illuminate\View\View
     */
    public function edit(Coupon $coupon)
    {
        return view('coupons::admin.edit')
            ->with(['model' => $coupon]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Coupons\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $coupon = $this->repository->create($request->all());

        return $this->redirect($request, $coupon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Coupons\Shells\Models\Coupon            $coupon
     * @param \TypiCMS\Modules\Coupons\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Coupon $coupon, FormRequest $request)
    {
        
        $this->repository->update($request->all());

        return $this->redirect($request, $coupon);
    }
}
