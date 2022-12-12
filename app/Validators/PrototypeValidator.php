<?php
namespace App\Validators;

class PrototypeValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Prototype,id'
    ];

    protected $rules = [
        'name' => 'required|max:100',
        'description' => 'required',
        'typeId' => 'required',
        'repositoryIds' => 'required',
        'technologyIds' => 'required'
    ];
}
