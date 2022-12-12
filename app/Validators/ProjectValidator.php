<?php
namespace App\Validators;

class ProjectValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Project,id'
    ];

    protected $rules = [
        'name' => 'required|max:100',
        'description' => 'required',
        'typeId' => 'required',
        'repositoryIds' => 'required',
        'technologyIds' => 'required'
    ];
}
