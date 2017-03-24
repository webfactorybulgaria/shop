<?php

namespace TypiCMS\Modules\Coupons\Models;

use Illuminate\Database\Eloquent\Builder;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;

class Coupon extends Base
{
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Coupons\Shells\Presenters\ModulePresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Fillable attributes for mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'sku',
        'value',
        'discount',
        'name',
        'description',
        'total_available',
        'total_available_user',
        'starts_at',
        'expires_at'
    ];

    protected $dates = [
        'starts_at',
        'expires_at'
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('shop.coupon_table');

    }

    /**
     * Rewrite base function ('status' needs to be 'active'; Translations case is removed)
     *
     * @param Builder $query
     *
     * @return Builder $query
     */
    public function scopeOnline(Builder $query)
    {
        return $query->where('active', 1);
    }
}
