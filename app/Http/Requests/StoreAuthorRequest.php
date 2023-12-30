<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Adapters\AuthorRequestAdapter;

class StoreAuthorRequest extends FormRequest
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
            'name' => 'required|max:40',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.max' => 'O campo Nome não pode conter mais que 40 caracteres.',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'O nome do Autor',
                'example' => 'Ariano Suassuna',
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return AuthorRequestAdapter::transform($this->all());
    }
}
