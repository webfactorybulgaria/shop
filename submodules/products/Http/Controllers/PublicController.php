<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Products\Shells\Http\Requests\PublicFormRequest;
use TypiCMS\Modules\Products\Shells\Repositories\ProductInterface;
use TypiCMS\Modules\Shop\Shells\Models\Cart;

class PublicController extends BasePublicController
{
    public function __construct(ProductInterface $product)
    {
        parent::__construct($product);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all();

        return view('products::public.index')
            ->with(compact('models'));
    }

    /**
     * Show news.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('products::public.show')
            ->with(compact('model'));
    }

    /**
     * Add product to user's basket.
     *
     * @return \Illuminate\View\View
     */
    public function add($slug, PublicFormRequest $request)
    {
        $attributes = $request->all();
        unset($attributes['_token']);

        $model = $this->repository->bySlug($slug);

        $cart = Cart::current();
        $cart->add($model, $attributes, 1);

        return redirect()->route(config('app.locale') . '.products.slug', ['slug' => $slug]);
    }
}
