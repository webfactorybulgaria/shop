<?php

namespace TypiCMS\Modules\Combinations\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;

class EloquentCombination extends RepositoriesAbstract implements CombinationInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
