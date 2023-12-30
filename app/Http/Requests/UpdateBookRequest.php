<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Adapters\BookRequestAdapter;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'max:40',
            'publishingCompany' => 'max:40',
            'edition' => 'integer',
            'yearPublication' => 'min:4|max:4',
            'value' => 'numeric',
            'authors' => 'required|array',
            'authors.*.id' => 'required|integer|exists:Autor,CodAu',
            'subjects' => 'required|array',
            'subjects.*.id' => 'required|integer|exists:Assunto,codAs',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'O campo Título não pode conter mais que 40 caracteres.',
            'publishingCompany.max' => 'O campo Editora não pode conter mais que 40 caracteres.',
            'yearPublication.min' => 'O campo Ano de Publicação deve conter 4 caracteres.',
            'yearPublication.max' => 'O campo Ano de Publicação deve conter 4 caracteres.',
            'value.float' => 'O campo Valor deve ser um número.',
            'authors.required' => 'É necessário ter pelo menos um Autor por Livro.',
            'authors.*.id.required' => 'É necessário informar o Id do Autor.',
            'authors.*.id.exists' => 'Um ou mais Autores informados não existem.',
            'subjects.required' => 'É necessário ter pelo menos um Assunto por Livro.',
            'subjects.*.id.required' => 'É necessário informar o Id do Assunto.',
            'subjects.*.id.exists' => 'Um ou mais Assuntos informados não existem.',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'O título do Livro',
                'example' => 'O senhor dos anéis',
            ],
            'publishingCompany' => [
                'description' => 'A Editora do Livro',
                'example' => 'Allen & Unwin',
            ],
            'Edition' => [
                'description' => 'A Edição do Livro',
                'example' => '1',
            ],
            'yearPublication' => [
                'description' => 'Ano de publicação do Livro',
                'example' => 1954,
            ],
            'value' => [
                'description' => 'Valor (preço) do Livro',
                'example' => 199.99,
            ],
            'authors.*.id' => [
                'description' => 'Id do Autor',
                'example' => '1',
            ],
            'subjects.*.id' => [
                'description' => 'Id do Assunto',
                'example' => '1',
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return BookRequestAdapter::transform($this->all());
    }
}
