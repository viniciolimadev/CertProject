<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Permite que qualquer usuário autenticado tente criar um projeto.
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'url_project' => 'nullable|url|max:2048',
            // 'public' é 'nullable' porque pode não vir se desmarcado,
            // mas 'boolean' ajuda o Laravel a entender os valores ('1', 'on').
            // O método `validated()` abaixo garante o valor final.
            'public'      => 'nullable|boolean',
        ];
    }

    /**
     * Get the validated data from the request, ensuring 'public' is a boolean.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        // Pega os dados validados normalmente.
        $validatedData = parent::validated();

        // Usa o método 'boolean' do FormRequest para converter 'public'.
        // Retorna true se 'public' for '1', 'true', 'on', 'yes'.
        // Retorna false se for '0', 'false', 'off', 'no', ou se não existir.
        $validatedData['public'] = $this->boolean('public');

        // Retorna os dados com 'public' garantido como booleano.
        return $validatedData;
    }

    /**
     * (Opcional) Você pode customizar as mensagens de erro aqui, se desejar.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do projeto é obrigatório.',
            'url_project.url' => 'Por favor, insira uma URL válida (ex: https://...).',
        ];
    }
}