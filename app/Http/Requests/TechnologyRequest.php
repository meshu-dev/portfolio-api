<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TechnologyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->has('user');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:100'
        ];
    }
}
