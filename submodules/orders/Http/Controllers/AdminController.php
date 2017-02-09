<?php

namespace TypiCMS\Modules\Orders\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Orders\Shells\Http\Requests\FormRequest;
use TypiCMS\Modules\Orders\Shells\Models\Order;
use TypiCMS\Modules\Orders\Shells\Repositories\OrderInterface;

class AdminController extends BaseAdminController
{
    public function __construct(OrderInterface $order)
    {
        parent::__construct($order);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('orders::admin.index');
    }

    /**
     * Show order.
     *
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        return view('orders::admin.show')
            ->with(compact('order'));
    }
}
