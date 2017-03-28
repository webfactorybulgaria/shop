<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Products\Shells\Models\Product;
use TypiCMS\Modules\Combinations\Shells\Models\Combination;
use TypiCMS\Modules\Products\Shells\Repositories\ProductInterface as Repository;
use DB;
use Combinations;

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
            $dateField = 'products.created_at';
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

    public function getOne($product)
    {
        $product = $this->repository->make()->where('products.id', $product)->first();
        $product->load('attribute_objects');
        // $product->attributes->load('items');

        return response()->json([
            'error' => !$product,
            'product' => $product,
        ], 200);
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
     * @param \TypiCMS\Modules\Products\Shells\Models\Product $product
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $deleted = $this->repository->delete($product);

        return response()->json([
            'error' => !$deleted,
        ]);
    }


    /**
     * Get combinations for product
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductCombinations($product)
    {
        $models = Combinations::allBy('product_id', $product, [], true);

        $errorText = empty($models) ? 'There was a problem with inserting this combination' : '' ;

        return response()->json([
            'error' => empty($models),
            'models' => $models,
            'errorText' => $errorText,
        ]);
    }

    /**
     * Generate combinations for product
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function combinations()
    {
        $request = Request::all();

        $response = new JsonResponse;
        $response->error = true;

        // Combinations::make()->where('product_id', $request['product'])->delete();
        $productCombinations = Combinations::make()->where('product_id', $request['product'])->get()->pluck('attribute_combo', 'attribute_combo');
        if(empty($request['delete'])) {
            $combinations = [];
            foreach ($request['combos'] as $key => $combo) {
                sort($combo);
                if (empty($productCombinations[implode(',', $combo)])) {
                    $combinations[$key]['attribute_combo'] = implode(',', $combo);
                    $combinations[$key]['stock'] = $request['defaultStock'];
                    $combinations[$key]['product_id'] = $request['product'];
                }
            }

            if(Combination::insert($combinations)) {
                $response->error = false;
            }
        } else {
            $response->error = false;
        }

        return json_encode($response);
    }
}
