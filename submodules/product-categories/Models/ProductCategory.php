<?php

namespace TypiCMS\Modules\ProductCategories\Models;

use TypiCMS\Modules\Core\Shells\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;

class ProductCategory extends Base
{
    use Historable;
    use PresentableTrait;
    use Translatable;

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
    protected $itemRouteName = 'product-category';

    /**
     * Shop specific attributes - slug
     *
     * @var array
     */
    protected $itemRouteParams = ['slug'];

    protected $presenter = 'TypiCMS\Modules\ProductCategories\Shells\Presenters\ModulePresenter';

    /**
     * Declare any properties that should be hidden from JSON Serialization.
     *
     * @var array
     */
    protected $hidden = [];

    protected $fillable = [
        'image',
        // Translatable columns
        'title',
        'slug',
        'status',
        'summary',
        'description',
        'meta_keywords',
        'meta_description'
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
        'description',
        'meta_keywords',
        'meta_description'
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
     * Get edit url of model.
     *
     * @return string|void
     */
    public function editUrl()
    {
        try {
            return route('admin::edit-product-category', [$this->id]);
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Get back office’s index of models url.
     *
     * @return string|void
     */
    public function indexUrl()
    {
        try {
            return route('admin::index-product-categories');
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * One product category has many products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function products()
    {
        return $this->morphedByMany('TypiCMS\Modules\Products\Shells\Models\Product', 'productcategoryable');
    }

}
