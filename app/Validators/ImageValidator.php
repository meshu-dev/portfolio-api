<?php
namespace App\Validators;

class ImageValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Image,id'
    ];

    protected $rules = [
        'name' => 'required|max:100|unique:App\Models\Image,name'
    ];
}
