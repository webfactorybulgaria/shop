<?php

namespace TypiCMS\Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{
	protected $fillable = [
		'item_id',
		'attribute_object_id',
		'attribute_object_type'
	];

    public function attributeObject()
    {
        return $this->morphTo();
    }

}
