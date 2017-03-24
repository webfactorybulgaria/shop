<?php

namespace TypiCMS\Modules\ProductCategories\Models;

use TypiCMS\Modules\Core\Shells\Models\BaseTranslation;

class ProductCategoryTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory', 'product_category_id')->withoutGlobalScopes();
    }
}
