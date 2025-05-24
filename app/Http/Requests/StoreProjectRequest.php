    <?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Support\Facades\Auth; // Necessário para Auth::check()

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
            // A lógica de quem é o dono será tratada no controller ao pegar o user_id.
            // Se você tivesse uma policy para 'create' Project::class, poderia usar:
            // return $this->user()->can('create', \App\Models\Project::class);
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
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'url_project' => 'nullable|url|max:2048', // Adicionado max:2048 para URLs
                'public' => 'nullable|boolean', // Laravel trata 'on' de checkbox como true
            ];
        }

        /**
         * Configure the validator instance.
         *
         * @param  \Illuminate\Validation\Validator  $validator
         * @return void
         */
        public function withValidator($validator)
        {
            $validator->sometimes('public', 'boolean', function ($input) {
                // Garante que o campo 'public' seja tratado como booleano mesmo se não enviado (checkbox desmarcado)
                // Isso é mais para a preparação dos dados do que para a validação em si,
                // pois a regra 'nullable|boolean' já lida com isso.
                // Mas pode ser útil se você quiser garantir que 'public' sempre exista no validated data.
                // No entanto, $request->boolean('public') no controller é mais direto.
                return true;
            });
        }

        /**
         * Get the validated data from the request.
         *
         * @return array
         */
        public function validated($key = null, $default = null)
        {
            $validatedData = parent::validated();

            // Garante que 'public' seja false se não estiver presente na requisição (checkbox desmarcado)
            // e true se estiver presente.
            $validatedData['public'] = $this->boolean('public');

            return $validatedData;
        }
    }
    