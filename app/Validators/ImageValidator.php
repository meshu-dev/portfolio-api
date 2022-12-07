<?php
namespace App\Validators;

class ImageValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Image,id'
    ];

    protected $rules = [
        'image' => 'required|file',
        'thumb' => 'in:true,false'
    ];
}
