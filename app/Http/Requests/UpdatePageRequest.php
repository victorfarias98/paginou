<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'thumbnail' => ['sometimes', 'string', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título deve ser uma string',
            'title.max' => 'O título não pode ter mais de 255 caracteres',
            'description.string' => 'A descrição deve ser uma string',
            'thumbnail.string' => 'A thumbnail deve ser uma string',
            'thumbnail.url' => 'A thumbnail deve ser uma URL válida',
        ];
    }
} 