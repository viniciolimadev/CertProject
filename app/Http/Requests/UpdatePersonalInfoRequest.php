<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Necessário para Rule::unique
use Illuminate\Validation\Rule; // Necessário para Rule

class UpdatePersonalInfoRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Apenas o usuário autenticado pode atualizar suas próprias informações.
        return Auth::check();
    }

    /**
     * Obtém as regras de validação que se aplicam à requisição.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // Dentro do método rules()
public function rules(): array
    {
        $userId = Auth::id();

        return [
            // --- GARANTA QUE ESTAS REGRAS ESTEJAM AQUI ---
            'name' => 'required|string|max:255', // <--- ESSENCIAL!
            'email' => [                          // <--- ESSENCIAL!
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId),
            ],
            // --- FIM DAS REGRAS ESSENCIAIS ---

            // Regras para o modelo UserProfile
            'phone' => 'nullable|string|max:20',
            'social_links' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cep' => 'nullable|string|max:9',
            'street_name' => 'nullable|string|max:255',
            'street_number' => 'nullable|string|max:50',
            'address_complement' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:150',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'marital_status' => 'nullable|string|max:50',
            'about_me' => 'nullable|string|max:2000',
        ];
    }

// Dentro do método attributes()
public function attributes(): array
{
    return [
        // ... (atributos existentes) ...
        'street_number' => 'número',
        'address_complement' => 'complemento',
        'bairro' => 'bairro',
        'marital_status' => 'estado civil',
        'date_of_birth' => 'data de nascimento',
        'nationality' => 'nacionalidade',
        'about_me' => 'sobre mim',
    ];
}

    /**
     * Prepara os dados para validação.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Aqui você poderia, por exemplo, limpar a máscara do CEP antes de validar/salvar,
        // mas por enquanto, manteremos simples, validando como string.
        // Exemplo:
        // if ($this->cep) {
        //     $this->merge([
        //         'cep' => preg_replace('/[^0-9]/', '', $this->cep)
        //     ]);
        // }
    }
}