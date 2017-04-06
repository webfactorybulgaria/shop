<?php

namespace TypiCMS\Modules\Orders\Models;

use TypiCMS\Modules\Core\Shells\Models\Base;

class OrderAddress extends Base
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'user_address_id',
        'first_name',
        'last_name',
        'company',
        'country',
        'state',
        'city',
        'address',
        'address2',
        'postcode',
        'phone'
    ];

    /**
     * User Address belongs to user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('TypiCMS\Modules\Users\Shells\Models\User');
    }

    /**
     * Order Address belongs to order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function order()
    {
        return $this->belongsTo('TypiCMS\Modules\Orders\Shells\Models\Order');
    }
}