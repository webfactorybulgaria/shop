<?php

namespace TypiCMS\Modules\Products\Http\Requests;

use TypiCMS\Modules\Core\Shells\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            '*.title' => 'max:255',
            '*.slug'  => 'max:255',
        ];
    }
}
