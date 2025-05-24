<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Permite que qualquer usuário autenticado tente criar um certificado.
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
            'title' => 'required|string|max:255',
            'file_path' => 'required|mimes:pdf|max:2048', // max 2MB
            'description_certificate' => 'nullable|string|max:5000', // Aumentado o limite da descrição
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'duration' => 'nullable|string|max:100',
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
            'title' => 'título',
            'file_path' => 'arquivo PDF',
            'description_certificate' => 'descrição',
            'start_date' => 'data de início',
            'end_date' => 'data de término',
            'duration' => 'duração',
        ];
    }
}
