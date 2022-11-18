<?php
namespace App\Validators;

class TechnologyValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Technology,id'
    ];

    protected $rules = [
        'name' => 'required|max:100|unique:App\Models\Technology,name'
    ];
}
