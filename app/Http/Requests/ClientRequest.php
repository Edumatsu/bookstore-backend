<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|max:255',
            'responsible_name' => 'required|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'The name of the client',
                'example' => 'NewOmni S/A',
            ],
            'responsible_name' => [
                'description' => 'The responsible name of the client',
                'example' => 'João Bezerra',
            ],
            'is_active' => [
                'description' => 'Field that determines whether the client is active',
                'example' => true,
            ]
        ];
    }
}
