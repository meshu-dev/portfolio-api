<?php
namespace App\Validators;

class ProjectValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Project,id'
    ];

    protected $rules = [
        'name' => 'required|max:100|unique:App\Models\Project,name'
    ];
}
