<?php

namespace TypiCMS\Modules\Combinations\Models;

use TypiCMS\Modules\Core\Shells\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;
use TypiCMS\Modules\Products\Shells\Models\Product;

class Combination extends Base
{
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Combinations\Shells\Presenters\ModulePresenter';

    /**
     * Declare any properties that should be hidden from JSON Serialization.
     *
     * @var array
     */
    protected $hidden = [];

    protected $fillable = [
        'product_id',
        'attribute_combo',
        'stock',
        'price',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
    ];

    protected $appends = ['thumb'];

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }

    public function scopeExists($query, $combos)
    {
        if (!is_array($combos))
            $combos = explode(',', $combos);
        sort($combos, SORT_NUMERIC);

        return $query->where('attribute_combo', implode(',', $combos));
    }
    /**
     * The combination belong to a product
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->with('translations');
    }
}
