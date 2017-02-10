<?php

namespace TypiCMS\Modules\Shop\Models;

use TypiCMS\Modules\Users\Models\User as BaseClass;
use Amsgames\LaravelShop\Traits\ShopUserTrait;

class User extends BaseClass
{
    use ShopUserTrait;

}