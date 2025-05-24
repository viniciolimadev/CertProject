<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Necessário para Rule::unique
use Illuminate\Validation\Rule; // Necessário para Rule

class UpdatePersonalInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Apenas o usuário autenticado pode atualizar suas próprias informações.
        // A rota para este controller já deve estar protegida pelo middleware 'auth'.
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = Auth::id(); // Pega o ID do usuário autenticado

        return [
            // Regras para o modelo User
            'name' => 'required|string|max:255',
            'email' => [ // E-mail do usuário (User model)
                'required', // Mantido como required, pois é um campo importante do usuário
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId), // Ignora o e-mail do próprio usuário na verificação de unicidade
            ],
            // Regras para o modelo UserProfile
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'social_links' => 'nullable|string|max:1000', // Aumentado o limite para redes sociais
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validação da imagem (até 2MB)
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'phone' => 'telefone',
            'photo' => 'foto de perfil',
            'social_links' => 'redes sociais',
            'city' => 'cidade',
            'state' => 'estado',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Converte a string de social_links em array antes da validação,
        // se a validação precisasse que fosse um array.
        // No entanto, como a regra é 'nullable|string', o controller fará a conversão.
        // Se quisesse validar como array:
        // if ($this->social_links && is_string($this->social_links)) {
        //     $this->merge([
        //         'social_links' => array_filter(array_map('trim', explode(',', $this->social_links))),
        //     ]);
        // }
    }
}
