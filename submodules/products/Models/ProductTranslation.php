<?php

namespace TypiCMS\Modules\Products\Models;

use TypiCMS\Modules\Core\Shells\Models\BaseTranslation;

class ProductTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Products\Shells\Models\Product', 'product_id')->withoutGlobalScopes();
    }
}
