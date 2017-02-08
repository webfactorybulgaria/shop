<?php

namespace TypiCMS\Modules\Products\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;

class EloquentProductPrice extends RepositoriesAbstract implements ProductPriceInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
