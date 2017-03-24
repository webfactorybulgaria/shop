<?php

namespace TypiCMS\Modules\Products\Models;

use TypiCMS\Modules\Core\Shells\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;
use TypiCMS\Modules\Attributes\Shells\Models\AttributeGroup;
use Amsgames\LaravelShop\Traits\ShoppableTrait;

class Product extends Base
{
    use Historable;
    use PresentableTrait;
    use Translatable;
    use ShoppableTrait;

    /**
     * Shop specific attributes - title
     *
     * @var string
     */
    protected $itemName = 'title';

    /**
     * Shop specific attributes - route name
     *
     * @var string
     */
    protected $itemRouteName = 'product';

    /**
     * Shop specific attributes - slug
     *
     * @var array
     */
    protected $itemRouteParams = ['slug'];

    protected $presenter = 'TypiCMS\Modules\Products\Shells\Presenters\ModulePresenter';

    /**
     * Declare any properties that should be hidden from JSON Serialization.
     *
     * @var array
     */
    protected $hidden = [];

    protected $fillable = [
        'image',
        'sku',
        'stock',
        'price',
        'tax',
        'shipping',
        // Translatable columns
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
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

    /**
     * Calculates a discount, based on the specific price rules of the product
     *
     * @return float
     */
    public function calculateDiscount()
    {
        //TODO
        return 0;
    }

    /**
     * A product has many attributes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function attributes()
    {
        return $this->morphToMany('TypiCMS\Modules\Attributes\Shells\Models\AttributeGroup', 'attributable')
            ->with('items')
            ->orderBy('value')
            ->withTimestamps();
    }

    /**
     * A product has many attribute combinations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function combinations()
    {
        return $this->hasMany('TypiCMS\Modules\Combinations\Shells\Models\Combination');
    }

    /**
     * A product has many attributes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function prices()
    {
        return $this->hasMany('TypiCMS\Modules\Products\Shells\Models\ProductPrice');
    }

    public function getAvailableAttributesAttribute()
    {
        $availableAttributes = $this->attributes()->get();

        $combinations = $this->combinations;
        $available = [];
        if (!empty($combinations)) {

            foreach($this->combinations->pluck('attribute_combo') as $combo) {
                $available = array_merge($available, explode(',', $combo));
            }
            $available = array_flip($available);

        }
        foreach ($availableAttributes as $key => $group) {
            $availableAttributes[$key]->items =
                    empty($available) ?
                    $group->items->pluck('value', 'id')->all() :
                    array_intersect_key($group->items->pluck('value', 'id')->all(), $available);
        }
        // dd($availableAttributes);
        return $availableAttributes;
    }

    public function getAvailableCombinationsAttribute()
    {
        return $this->combinations->keyBy('attribute_combo');
    }

}
