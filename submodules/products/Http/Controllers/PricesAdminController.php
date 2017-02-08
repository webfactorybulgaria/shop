<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Products\Shells\Http\Requests\PriceFormRequest;
use TypiCMS\Modules\Products\Shells\Models\Product;
use TypiCMS\Modules\Products\Shells\Models\ProductPrice;
use TypiCMS\Modules\Products\Shells\Repositories\ProductPriceInterface;

class PricesAdminController extends BaseAdminController
{
    public function __construct(ProductPriceInterface $product)
    {
        parent::__construct($product);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('products::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Product $product)
    {
        $model = $this->repository->getModel();

        return view('products::admin.create-price')
            ->with(compact('model', 'product'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Products\Shells\Models\Product $product
     * @param \TypiCMS\Modules\Products\Shells\Models\ProductPrice $price
     *
     * @return \Illuminate\View\View
     */
    public function edit(Product $product, ProductPrice $price)
    {
        app('JavaScript')->put('price', $price);

        return view('products::admin.edit-price')
            ->with(['model' => $price, 'product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Products\Shells\Models\Product $product
     * @param \TypiCMS\Modules\Products\Shells\Http\Requests\PriceFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Product $product, PriceFormRequest $request)
    {
        $data = $request->all();
        $data['product_id'] = $product->id;
        $productprice = $this->repository->create($data);

        return $this->redirect($request, $productprice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Products\Shells\Models\Product            $product
     * @param \TypiCMS\Modules\Products\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Product $product, ProductPrice $price, PriceFormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $price);
    }
}
