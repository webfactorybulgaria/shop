<?php

namespace TypiCMS\Modules\Combinations\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Combinations\Shells\Models\Combination;
use TypiCMS\Modules\Combinations\Shells\Repositories\CombinationInterface as Repository;

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
        $request = Request::all();
        $models = [];
        /*
        $condition = '';
        foreach (explode(',', $request['attribute_combo']) as $value) {
            $condition .= "FIND_IN_SET('".$value."', attribute_combo) AND ";
        }
        $condition = rtrim($condition, ' AND ');
        */

        $exists = $this->repository->make()->where('product_id', $request['product_id'])->exists($request['attribute_combo'])->get();

        if($exists->isEmpty()) {
            $model = $this->repository->create($request);
            $models = $this->repository->allBy('product_id', $request['product_id'], [], true);
            $error = $model ? false : true;
            $errorText = $error ? 'There was a problem with inserting this combination' : '' ;
        } else {
            $error = true;
            $errorText = 'This combination already exists';
        }

        return response()->json([
            'error' => $error,
            'models' => $models,
            'errorText' => $errorText,
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
     * @param \TypiCMS\Modules\Combinations\Shells\Models\Combination $combination
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Combination $combination)
    {
        $deleted = $this->repository->delete($combination);
        $errorText = !$deleted ? 'There was a problem with deleting this element' : '';

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    /**
     * Load "insert combination template/form from fancybox call"
     *
     * @return View
     */
    public function loadPopup()
    {
        return view('products::admin._insert-combination-popup');
    }
}
