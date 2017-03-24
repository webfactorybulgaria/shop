<?php

namespace TypiCMS\Modules\ProductCategories\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BasePublicController;
use TypiCMS\Modules\ProductCategories\Shells\Http\Requests\PublicFormRequest;
use TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory;
use TypiCMS\Modules\ProductCategories\Shells\Repositories\ProductCategoryInterface;


class PublicController extends BasePublicController
{
    public function __construct(ProductCategoryInterface $product_category)
    {
        parent::__construct($product_category, 'product_categories');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all();

        return view('product-categories::public.index')
            ->with(compact('models'));
    }

    /**
     * Show products.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);
        
        return view('product-categories::public.show')
            ->with(compact('model'));
    }

}
