<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Adapters\SubjectRequestAdapter;

class StoreSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'description' => 'required|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O campo Assunto é obrigatório.',
            'description.max' => 'O campo Assunto não pode conter mais que 20 caracteres.',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'description' => [
                'description' => 'Assunto',
                'example' => 'Romance',
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return SubjectRequestAdapter::transform($this->all());
    }
}
