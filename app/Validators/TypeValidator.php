<?php
namespace App\Validators;

class TypeValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Type,id'
    ];

    protected $rules = [
        'name' => 'required|max:100|unique:App\Models\Type,name'
    ];
}
