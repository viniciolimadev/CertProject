<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Permite que qualquer usuário autenticado tente criar uma experiência.
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
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000', // Aumentado o limite
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
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
            'position' => 'cargo',
            'company' => 'empresa',
            'description' => 'descrição',
            'start_date' => 'data de início',
            'end_date' => 'data de término',
        ];
    }
}
