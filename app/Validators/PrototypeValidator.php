<?php
namespace App\Validators;

class PrototypeValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Prototype,id'
    ];

    protected $rules = [
        'name' => 'required|max:100|unique:App\Models\Prototype,name',
        'repositoryIds' => 'required',
        'technologyIds' => 'required'
    ];
}
