<?php

namespace TypiCMS\Modules\Coupons\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;

class EloquentCoupon extends RepositoriesAbstract implements CouponInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
