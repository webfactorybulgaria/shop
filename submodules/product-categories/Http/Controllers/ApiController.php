<?php

namespace TypiCMS\Modules\ProductCategories\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseApiController;
use TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory;
use TypiCMS\Modules\ProductCategories\Shells\Repositories\ProductCategoryInterface as Repository;
use DB;

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

    public function index($builder = null)
    {
        // dirty hack as created_at is ambigious
        $request = Request::all();
        if (!empty($request['tableState'])) {
            $tableState = json_decode($request["tableState"]);
            $dateField = 'product_categories.created_at';
            if ($tableState->sort->predicate == 'date')
                $tableState->sort->predicate = $dateField;
            if (!empty($tableState->search->predicateObject->date)){
                $tableState->search->predicateObject->$dateField = $tableState->search->predicateObject->date;
                unset($tableState->search->predicateObject->date);
            }
            Request::replace(['tableState' => json_encode($tableState)]);

        }

        return parent::index($builder);
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
     * @param \TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory $productCategory
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProductCategory $product_category)
    {
        $deleted = $this->repository->delete($product_category);

        return response()->json([
            'error' => !$deleted,
        ]);
    }

}
