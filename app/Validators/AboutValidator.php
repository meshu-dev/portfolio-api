<?php

namespace App\Validators;

class AboutValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\About,id'
    ];

    protected $rules = [
        'text' => 'required|min:3|max:500'
    ];
}
