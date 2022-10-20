<?php
namespace App\Validators;

class RepositoryValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Repository,id'
    ];

    protected $rules = [
        'name' => 'required|max:100|unique:App\Models\Repository,name'
    ];
}
