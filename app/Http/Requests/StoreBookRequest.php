<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Adapters\BookRequestAdapter;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:40',
            'publishingCompany' => 'required|max:40',
            'edition' => 'required|integer',
            'yearPublication' => 'required|min:4|max:4',
            'value' => 'required|numeric',
            'authors' => 'required|array',
            'authors.*.id' => 'required|integer|exists:Autor,CodAu',
            'subjects' => 'required|array',
            'subjects.*.id' => 'required|integer|exists:Assunto,codAs',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O campo Título é obrigatório.',
            'title.max' => 'O campo Título não pode conter mais que 40 caracteres.',
            'publishingCompany.required' => 'O campo Editora é obrigatório.',
            'publishingCompany.max' => 'O campo Editora não pode conter mais que 40 caracteres.',
            'Edition.required' => 'O campo Edição é obrigatório.',
            'yearPublication.required' => 'O campo Ano de Publicação é obrigatório.',
            'yearPublication.min' => 'O campo Ano de Publicação deve conter 4 caracteres.',
            'yearPublication.max' => 'O campo Ano de Publicação deve conter 4 caracteres.',
            'value.required' => 'O campo Valor é obrigatório.',
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
