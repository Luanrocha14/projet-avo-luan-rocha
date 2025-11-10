<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Se estiver atualizando, pega o ID do usuário
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            // Senha obrigatória apenas no cadastro (POST)
            'password' => $this->isMethod('POST')
                ? ['required', 'min:6', 'confirmed']
                : ['nullable', 'min:6', 'confirmed'],

            // Campo de confirmação da senha (precisa existir no formulário)
            'password_confirmation' => ['nullable', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo nome é obrigatório!',
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Necessário enviar um e-mail válido!',
            'email.unique' => 'Este e-mail já está sendo utilizado!',
            'password.required' => 'Campo senha é obrigatório!',
            'password.min' => 'A senha deve ter no mínimo :min caracteres!',
            'password.confirmed' => 'A confirmação de senha não confere!',
        ];
    }
}
