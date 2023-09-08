<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'type' => ['required', 'in:admin,client'],
            'name' => [],
            'email' => [],
            'password' => [],
            // 'cpf' => ['required', 'size:11'],
            'cep' => ['size:8'],
            'street' => [],
            'neighborhood' => [],
            'city' => [],
            'state' => ['size:2']
        ];
    }
}
