<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['required', 'string', 'url'],
            'page_id' => ['required', 'exists:pages,id'],
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
            'price.required' => 'O preço é obrigatório',
            'price.numeric' => 'O preço deve ser um número',
            'price.min' => 'O preço não pode ser negativo',
            'image.required' => 'A imagem é obrigatória',
            'image.string' => 'A imagem deve ser uma string',
            'image.url' => 'A imagem deve ser uma URL válida',
            'page_id.required' => 'O ID da página é obrigatório',
            'page_id.exists' => 'A página selecionada não existe',
        ];
    }
} 