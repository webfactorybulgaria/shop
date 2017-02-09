<?php

namespace TypiCMS\Modules\Orders\Models;

use Amsgames\LaravelShop\Models\ShopOrderModel;

class Order extends ShopOrderModel
{
	protected $appends = ['displayTotalPrice'];
}
