<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLivroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Titulo' => 'min:3|max:40',
            'Editora' => 'min:3|max:40',
            'Edicao' => 'integer',
            'AnoPublicacao' => 'min:4|max:4'
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'Titulo' => [
                'description' => 'O título do Livro',
                'example' => 'O senhor dos anéis',
            ],
            'Editora' => [
                'description' => 'A Editora do Livro',
                'example' => 'Allen & Unwin',
            ],
            'Edicao' => [
                'description' => 'A Edição do Livro',
                'example' => '1',
            ],
            'AnoPublicacao' => [
                'description' => 'Ano de publicação do Livro',
                'example' => 1954,
            ],
        ];
    }
}
