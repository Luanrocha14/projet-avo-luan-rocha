<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'Campo nome é obrigatótio!',
            'email.required' => 'Campo email é obrigatório!',
            'email.email' => 'Necessário enviar e-mail válido!',
            'password.required' => 'Campo senha é obrigatório!',
            'password.min' => 'senha com no mínimo :min caracteres!',
            
        ];
    }
}
