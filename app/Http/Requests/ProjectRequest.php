<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|min:3|max:100',
            'description'   => 'required',
            'url'           => 'required|url',
            'typeId'        => 'required|exists:App\Models\Type,id',
            'repositoryIds' => 'required|array',
            'technologyIds' => 'required|array'
        ];
    }
}
