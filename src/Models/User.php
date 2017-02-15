<?php

namespace TypiCMS\Modules\Shop\Models;

use TypiCMS\Modules\Users\Models\User as BaseClass;
use Amsgames\LaravelShop\Traits\ShopUserTrait;
use TypiCMS\Modules\Shop\Shells\Models\Cart as BaseCart;

class User extends BaseClass
{
    use ShopUserTrait;

    public function getCartAttribute()
    {
        return BaseCart::current();
    }
}