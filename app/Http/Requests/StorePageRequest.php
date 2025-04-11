<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'thumbnail' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório',
            'title.string' => 'O título deve ser uma string',
            'title.max' => 'O título não pode ter mais de 255 caracteres',
            'description.required' => 'A descrição é obrigatória',
            'description.string' => 'A descrição deve ser uma string',
            'thumbnail.required' => 'A thumbnail é obrigatória',
            'thumbnail.string' => 'A thumbnail deve ser uma string',
            'thumbnail.url' => 'A thumbnail deve ser uma URL válida',
        ];
    }
} 