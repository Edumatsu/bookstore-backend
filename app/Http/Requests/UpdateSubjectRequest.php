<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Adapters\SubjectRequestAdapter;

class UpdateSubjectRequest extends FormRequest
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
            'subject' => 'max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'O campo Assunto é obrigatório.',
            'subject.max' => 'O campo Assunto não pode conter mais que 40 caracteres.',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'subject' => [
                'description' => 'O Assunto',
                'example' => 'Romance',
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return SubjectRequestAdapter::transform($this->all());
    }
}
