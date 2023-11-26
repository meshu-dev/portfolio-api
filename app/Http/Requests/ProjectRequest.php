<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->has('user');
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|min:3|max:100',
            'description'  => 'required',
            'url'          => 'required|url',
            'type'         => 'required|exists:App\Models\Type,id',
            'repositories' => 'required|array',
            'technologies' => 'required|array'
        ];
    }
}
