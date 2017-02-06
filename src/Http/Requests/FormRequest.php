<?php

namespace TypiCMS\Modules\Products\Shells\Http\Requests;

use TypiCMS\Modules\Core\Shells\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image'   => 'image|max:2000',
            '*.title' => 'max:255',
            '*.slug'  => 'max:255',
        ];
    }
}
