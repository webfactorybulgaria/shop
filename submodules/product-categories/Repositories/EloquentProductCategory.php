<?php

namespace TypiCMS\Modules\ProductCategories\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;

class EloquentProductCategory extends RepositoriesAbstract implements ProductCategoryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
