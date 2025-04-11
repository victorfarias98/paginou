<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'price' => ['sometimes', 'numeric', 'min:0'],
            'duration' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título deve ser uma string',
            'title.max' => 'O título não pode ter mais de 255 caracteres',
            'description.string' => 'A descrição deve ser uma string',
            'price.numeric' => 'O preço deve ser um número',
            'price.min' => 'O preço não pode ser negativo',
            'duration.integer' => 'A duração deve ser um número inteiro',
            'duration.min' => 'A duração deve ser pelo menos 1 minuto',
        ];
    }
} 