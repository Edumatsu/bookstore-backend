<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required|min:3|max:150',
            'email' => 'required_without_all:phone|email|max:150',
            'cpf' => 'max:11',
            'cnpj' => 'max:14',
            'phone' => 'max:20',
            'custom_fields' => 'present|array',
            'custom_fields.*.custom_customer_field_id' => 'required|integer',
            'custom_fields.*.value' => 'required',
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'The name of the customer',
                'example' => 'Jhon Silva Saur',
            ],
            'email' => [
                'description' => 'The e-mail of customer',
                'example' => 'dinosaur_family@gmail.com',
            ],
            'cpf' => [
                'description' => 'The CPF of customer',
                'example' => '12345678910',
            ],
            'cnpj' => [
                'description' => 'The CNPJ of customer (for employers)',
                'example' => '000123450001',
            ],
            'phone' => [
                'description' => 'The phone of customer',
                'example' => '5514998776655',
            ],
            'custom_fields.*.custom_customer_field_id' => [
                'description' => 'The id of custom customer field previously registered',
                'example' => '1',
            ],
            'custom_fields.*.value' => [
                'description' => 'The value of custom field related of customer',
                'example' => 'Sim',
            ],
        ];
    }
}
