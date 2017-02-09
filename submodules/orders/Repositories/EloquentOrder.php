<?php

namespace TypiCMS\Modules\Orders\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;

class EloquentOrder extends RepositoriesAbstract implements OrderInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
