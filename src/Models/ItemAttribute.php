<?php

namespace TypiCMS\Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{
	protected $fillable = [
		'item_id',
		'group_class',
		'group_value',
		'attribute_class',
		'attribute_reference_id',
		'attribute_value'
	];
}
