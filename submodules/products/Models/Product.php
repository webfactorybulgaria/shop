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
    use ShoppableTrait {
        getSpecificBasePrice as traitGetSpecificBasePrice;
    }

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
    public function attributeObjects()
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
        $availableAttributes = $this->attributeObjects;

        $combinations = $this->combinations;
        $available = [];
        if (!empty($combinations)) {

            foreach($this->combinations->pluck('attribute_combo') as $combo) {
                $available = array_merge($available, explode(',', $combo));
            }
            $available = array_flip($available);

        }

        $retAvailableAttributes = [];
        foreach ($availableAttributes as $key => $group) {
            $retAvailableAttributes[$key] = clone $group;

            $retAvailableAttributes[$key]->items =
                    empty($available) ?
                    $group->items->pluck('value', 'id')->all() :
                    array_intersect_key($group->items->pluck('value', 'id')->all(), $available);
        }

        return $retAvailableAttributes;
    }

    public function getAvailableCombinationsAttribute()
    {
        return $this->combinations->keyBy('attribute_combo');
    }

    /**
     * A product has many galleries.
     *
     * @return MorphToMany
     */
    public function galleries()
    {
        return $this->morphToMany('TypiCMS\Modules\Galleries\Shells\Models\Gallery', 'galleryable')
            ->withPivot('position')
            ->orderBy('position')
            ->withTimestamps();
    }

    /**
     * A product has many product categories
     *
     * @return MorphToMany
     */
    public function product_categories()
    {
        return $this->morphToMany('TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory', 'productcategoryable')
            ->withPivot('position')
            ->orderBy('position')
            ->withTimestamps();
    }
    public function getSpecificBasePrice($qtty, $attributes, $cart)
    {
        if (!empty($attributes)) {
            $availableCombinations = $this->availableCombinations;
            if (!empty($availableCombinations)) {
                $arrAttributeIds = [];
                foreach($attributes as $attr) {
                    if ($attr->attribute_object_type == config('shop.attribute_models.product_attribute')) {
                        $arrAttributeIds[] = $attr->attribute_object_id;
                    }
                }

                sort($arrAttributeIds, SORT_NUMERIC);
                $key = implode(',', $arrAttributeIds);

                if (!empty($this->availableCombinations[$key]) && ($this->availableCombinations[$key]->price > 0)){
                    return $this->availableCombinations[$key]->price;
                }
            }
        }

        return $this->traitGetSpecificBasePrice($qtty, $attributes, $cart);
    }
}
