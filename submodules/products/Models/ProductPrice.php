<?php

namespace TypiCMS\Modules\Products\Models;

use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\Attributes\Shells\Models\AttributeGroup;

class ProductPrice extends Base
{
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Products\Shells\Presenters\ModulePresenter';

    protected $fillable = [
        'currency',
        'product_id',
        'starting_at',
        'specific_price',
        'specific_price_status',
        'discount',
        'discount_type',
        'date_from',
        'date_to',
    ];

    /**
     * A product price belogns to a product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belognsTo
     */
    public function product()
    {
        return $this->belognsTo('TypiCMS\Modules\Products\Shells\Models\Product');
    }

    /**
     * Get edit url of model.
     *
     * @return string|void
     */
    public function editUrl()
    {
        try {
            return route('admin::edit-productprice', [$this->product_id, $this->id]);
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
            return route('admin::edit-product', $this->product_id);
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage());
        }
    }
}
