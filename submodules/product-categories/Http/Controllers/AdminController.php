<?php

namespace TypiCMS\Modules\ProductCategories\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\ProductCategories\Shells\Http\Requests\FormRequest;
use TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory;
use TypiCMS\Modules\ProductCategories\Shells\Repositories\ProductCategoryInterface;

class AdminController extends BaseAdminController
{
    public function __construct(ProductCategoryInterface $product_category)
    {
        parent::__construct($product_category);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('product-categories::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('product-categories::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory $product
     *
     * @return \Illuminate\View\View
     */
    public function edit(ProductCategory $product_category)
    {
        return view('product-categories::admin.edit')
            ->with(['model' => $product_category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\ProductCategories\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $product_category = $this->repository->create($request->all());

        return $this->redirect($request, $product_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory    $productCategory
     * @param \TypiCMS\Modules\ProductCategories\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductCategory $product_category, FormRequest $request)
    {
        $this->repository->update($request->all());
        
        return $this->redirect($request, $product_category);
    }
}
