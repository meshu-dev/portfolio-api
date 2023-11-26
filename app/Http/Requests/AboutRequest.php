<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->has('user');
    }

    public function rules(): array
    {
        return [
            'text' => 'required|min:3|max:500'
        ];
    }
}
