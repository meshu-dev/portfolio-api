<?php
namespace App\Validators;

use Illuminate\Validation\Rule;
use App\Exceptions\ValidationException;

class AboutValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\About,id'
    ];

    protected $rules = [
        'text' => 'required|max:500'
    ];
}
