<?php

namespace TypiCMS\Modules\Coupons\Http\Requests;

use TypiCMS\Modules\Core\Shells\Http\Requests\AbstractFormRequest;

class PublicRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'coupon' => 'required|max:255',
        ];
    }
}
