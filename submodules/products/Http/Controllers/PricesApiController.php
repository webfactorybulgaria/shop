<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Products\Shells\Models\Product;
use TypiCMS\Modules\Products\Shells\Repositories\ProductInterface as Repository;
use DB;

class PricesApiController extends BaseApiController
{

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Products\Shells\Models\ProductPrice $price
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProductPrice $price)
    {
        $deleted = $this->repository->delete($price);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
