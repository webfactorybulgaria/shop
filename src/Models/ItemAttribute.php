<?php

namespace TypiCMS\Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{
	protected $fillable = [
		'item_id',
		'atribute_object_id',
		'atribute_object_type'
	];

    public function atributeObject()
    {
        return $this->morphTo();
    }

}
