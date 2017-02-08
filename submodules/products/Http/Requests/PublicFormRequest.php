<?php

namespace TypiCMS\Modules\Products\Http\Requests;

use TypiCMS\Modules\Core\Shells\Http\Requests\AbstractFormRequest;

class PublicFormRequest extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [];

        //attributes rules go here in the following format:
        //$rules['attribute'] = 'required|...';

        return $rules;
    }
}
