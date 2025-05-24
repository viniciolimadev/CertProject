<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Dados Pessoais') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Editar Dados Pessoais</h1>

                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 rounded relative bg-green-100 border border-green-400 text-green-700" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Formulário para erros de validação, se necessário --}}
                    {{-- @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <div class="font-bold">Oops! Algo deu errado.</div>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <form method="POST" action="{{ route('personal_info.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil:</label>
                            <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @if (!empty($profile->photo_path))
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto atual"
                                        class="max-w-[150px] h-auto rounded-md shadow">
                                </div>
                            @endif
                            {{-- Exemplo de como exibir erro para este campo --}}
                            {{-- @error('photo')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror --}}
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome:</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            {{-- @error('name') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone:</label>
                            <input type="tel" id="phone" name="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   value="{{ old('phone', $profile->phone ?? '') }}" maxlength="17" placeholder="+55 85 99999-9999">
                            {{-- @error('phone') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade:</label>
                            <input type="text" id="city" name="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   value="{{ old('city', $profile->city ?? '') }}">
                            {{-- @error('city') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Estado:</label>
                            <input type="text" id="state" name="state" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   value="{{ old('state', $profile->state ?? '') }}">
                            {{-- @error('state') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail:</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   value="{{ old('email', $profile->email ?? auth()->user()->email) }}">
                            {{-- @error('email') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div>
                            <label for="social_links" class="block text-sm font-medium text-gray-700 mb-1">Redes Sociais (separadas por vírgula):</label>
                            <textarea id="social_links" name="social_links" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="3">{{ old('social_links', is_array($profile->social_links ?? '') ? implode(', ', $profile->social_links) : ($profile->social_links ?? '')) }}</textarea>
                            {{-- @error('social_links') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const phoneInput = document.getElementById('phone');
        if (phoneInput) { // Adiciona verificação para evitar erro se o elemento não existir
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

                // Removido o if (value.startsWith('55')) para simplificar e garantir o +55
                // value = value.substring(2); (se existir)

                let formatted = '+55'; // Começa com +55

                if (value.length > 0) {
                    formatted += ' ' + value.substring(0, 2); // DDD
                }
                if (value.length > 2) { // Ajustado de >=3 para >2 para pegar o primeiro dígito do número
                    // Para números com 9 dígitos (ex: celular) ou 8 dígitos (fixo)
                    let nineDigit = value.substring(2,3) === '9'; // Checa se o primeiro dígito do número é 9
                    let mainNumberLength = nineDigit ? 5 : 4;
                    
                    formatted += ' ' + value.substring(2, 2 + mainNumberLength); 
                    if (value.length > (2 + mainNumberLength)) {
                        formatted += '-' + value.substring(2 + mainNumberLength, 2 + mainNumberLength + 4);
                    } else if (value.length > 2 && value.length <= (2 + mainNumberLength) ) {
                        // caso incompleto
                    }

                }
                // Limita o tamanho máximo do input visualmente, já que maxlength não funciona bem com formatação dinâmica
                e.target.value = formatted.substring(0, 17); // +55 (XX) XXXXX-XXXX (17 caracteres)
            });
        }
    </script>
    @endpush

</x-app-layout>