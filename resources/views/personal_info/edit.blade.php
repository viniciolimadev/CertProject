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
                        <div class="mb-4 px-4 py-3 rounded relative bg-green-100 border border-green-400 text-green-700"
                             role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <div class="font-bold">Oops! Verifique os erros abaixo.</div>
                            {{-- Se quiser listar os erros individualmente (opcional):
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            --}}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('personal_info.update') }}" enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Foto de Perfil --}}
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto de
                                Perfil:</label>
                            <input type="file" id="photo" name="photo"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                          @error('photo') border border-red-500 @else border border-gray-300 @enderror">
                            @if ($profile->photo_path)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto atual"
                                         class="max-w-[150px] h-auto rounded-md shadow">
                                </div>
                            @endif
                            @error('photo')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nome --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome:</label>
                            <input type="text" id="name" name="name"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('name') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail:</label>
                            <input type="email" id="email" name="email"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('email') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Telefone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone:</label>
                            <input type="tel" id="phone" name="phone"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('phone') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('phone', $profile->phone ?? '') }}" maxlength="15"
                                   placeholder="(XX) XXXXX-XXXX">
                            @error('phone')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- CEP --}}
                        <div>
                            <label for="cep" class="block text-sm font-medium text-gray-700 mb-1">CEP:</label>
                            <input type="text" id="cep" name="cep"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('cep') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('cep', $profile->cep ?? '') }}" placeholder="00000-000" maxlength="9">
                            @error('cep')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nome da Rua --}}
                        <div>
                            <label for="street_name" class="block text-sm font-medium text-gray-700 mb-1">Nome da Rua:</label>
                            <input type="text" id="street_name" name="street_name"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('street_name') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('street_name', $profile->street_name ?? '') }}">
                            @error('street_name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Número --}}
                        <div>
                            <label for="street_number" class="block text-sm font-medium text-gray-700 mb-1">Número:</label>
                            <input type="text" id="street_number" name="street_number"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('street_number') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('street_number', $profile->street_number ?? '') }}"
                                   placeholder="Ex: 123 ou S/N">
                            @error('street_number')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Complemento --}}
                        <div>
                            <label for="address_complement" class="block text-sm font-medium text-gray-700 mb-1">Complemento:</label>
                            <input type="text" id="address_complement" name="address_complement"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('address_complement') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('address_complement', $profile->address_complement ?? '') }}"
                                   placeholder="Ex: Apto 101, Bloco B">
                            @error('address_complement')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Bairro --}}
                        <div>
                            <label for="bairro" class="block text-sm font-medium text-gray-700 mb-1">Bairro:</label>
                            <input type="text" id="bairro" name="bairro"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('bairro') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('bairro', $profile->bairro ?? '') }}">
                            @error('bairro')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Cidade --}}
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade:</label>
                            <input type="text" id="city" name="city"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('city') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('city', $profile->city ?? '') }}">
                            @error('city')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Estado:</label>
                            <input type="text" id="state" name="state"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('state') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('state', $profile->state ?? '') }}">
                            @error('state')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Data de Nascimento --}}
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento:</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('date_of_birth') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('date_of_birth', $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}">
                            @error('date_of_birth')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nacionalidade --}}
                        <div>
                            <label for="nationality" class="block text-sm font-medium text-gray-700 mb-1">Nacionalidade:</label>
                            <input type="text" id="nationality" name="nationality"
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                          @error('nationality') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                   value="{{ old('nationality', $profile->nationality ?? '') }}" placeholder="Ex: Brasileira(o)">
                            @error('nationality')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Estado Civil --}}
                        <div>
                            <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">Estado Civil:</label>
                            <select id="marital_status" name="marital_status"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                           @error('marital_status') border-red-500 @else border-gray-300 @enderror"> {/* Correção Tailwind */}
                                <option value="">Selecione...</option>
                                @php $currentStatus = old('marital_status', $profile->marital_status ?? ''); @endphp
                                <option value="Solteiro(a)" @selected($currentStatus == 'Solteiro(a)')>Solteiro(a)</option>
                                <option value="Casado(a)" @selected($currentStatus == 'Casado(a)')>Casado(a)</option>
                                <option value="Divorciado(a)" @selected($currentStatus == 'Divorciado(a)')>Divorciado(a)</option>
                                <option value="Viúvo(a)" @selected($currentStatus == 'Viúvo(a)')>Viúvo(a)</option>
                                <option value="União Estável" @selected($currentStatus == 'União Estável')>União Estável</option>
                                <option value="Outro" @selected($currentStatus == 'Outro')>Outro</option>
                            </select>
                            @error('marital_status')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Sobre Mim --}}
                        <div>
                            <label for="about_me" class="block text-sm font-medium text-gray-700 mb-1">Sobre Mim:</label>
                            <textarea id="about_me" name="about_me"
                                      class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                             @error('about_me') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                      rows="4">{{ old('about_me', $profile->about_me ?? '') }}</textarea>
                            @error('about_me')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Redes Sociais --}}
                        <div>
                            <label for="social_links" class="block text-sm font-medium text-gray-700 mb-1">Redes Sociais (URLs separadas por vírgula):</label>
                            <textarea id="social_links" name="social_links"
                                      class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                             @error('social_links') border-red-500 @else border-gray-300 @enderror" {{-- Correção Tailwind --}}
                                      rows="3">{{ old('social_links', is_array($profile->social_links ?? null) ? implode(', ', $profile->social_links) : ($profile->social_links ?? '')) }}</textarea>
                            @error('social_links')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botão Salvar --}}
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- O SCRIPT JAVASCRIPT (para máscaras e CEP) que você enviou continua o mesmo e está correto --}}
    <script>
        // Garante que o script rode APÓS o HTML estar pronto
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM Carregado. Iniciando scripts..."); // Ponto de Teste Inicial

            // --- MÁSCARA PARA TELEFONE ---
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                console.log("Campo 'phone' encontrado.");
                const applyPhoneMask = (e) => {
                    let value = e.target.value.replace(/\D/g, ''); // 1. Remove tudo que não for dígito
                    value = value.substring(0, 11); // 2. Limita o número de dígitos crus
                    let formatted = '';
                    if (value.length === 0) {
                        formatted = '';
                    } else if (value.length <= 2) {
                        formatted = `(${value}`;
                    } else {
                        const ddd = value.substring(0, 2);
                        const numberPart = value.substring(2);
                        formatted = `(${ddd}) `;
                        if (numberPart.length === 0) {
                            formatted = `(${ddd})`;
                        } else if (numberPart[0] === '9' && numberPart.length <= 5) {
                            formatted += numberPart;
                        } else if (numberPart[0] === '9' && numberPart.length > 5) {
                            formatted += `${numberPart.substring(0, 5)}-${numberPart.substring(5, 9)}`;
                        } else if (numberPart.length <= 4) {
                            formatted += numberPart;
                        } else if (numberPart.length > 4) {
                            formatted += `${numberPart.substring(0, 4)}-${numberPart.substring(4, 8)}`;
                        }
                    }
                    e.target.value = formatted.substring(0, 15);
                };
                phoneInput.addEventListener('input', applyPhoneMask);
                if (phoneInput.value) { // Aplica ao carregar se já houver valor
                  applyPhoneMask({ target: phoneInput });
                }
            } else {
                console.error("ERRO: Campo 'phone' NÃO encontrado!");
            }

            // --- MÁSCARA E BUSCA PARA CEP ---
            const cepInput = document.getElementById('cep');
            if (cepInput) {
                console.log("Campo 'cep' encontrado.");
                const applyCepMask = (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.substring(0, 8);
                    if (value.length > 5) {
                        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
                    }
                    e.target.value = value;
                };
                cepInput.addEventListener('input', applyCepMask);
                if (cepInput.value) { // Aplica ao carregar se já houver valor
                    applyCepMask({ target: cepInput });
                }

                cepInput.addEventListener('blur', function() {
                    console.log("Evento 'blur' (saída) do CEP disparado.");
                    const cepValue = this.value.replace(/\D/g, '');
                    if (cepValue.length === 8) {
                        console.log("CEP tem 8 dígitos. Iniciando busca para:", cepValue);
                        const streetInput = document.getElementById('street_name');
                        const bairroInput = document.getElementById('bairro');
                        const cityInput = document.getElementById('city');
                        const stateInput = document.getElementById('state');
                        if (!streetInput || !bairroInput || !cityInput || !stateInput) {
                            console.error("ERRO: Um ou mais campos de endereço (rua, bairro, cidade, estado) não foram encontrados! Verifique os IDs no HTML.");
                            return;
                        }
                        streetInput.value = 'Buscando...';
                        bairroInput.value = 'Buscando...';
                        cityInput.value = 'Buscando...';
                        stateInput.value = 'Buscando...';
                        fetch(`https://viacep.com.br/ws/${cepValue}/json/`)
                            .then(response => {
                                console.log("Resposta da API ViaCEP recebida. Status:", response.status);
                                if (!response.ok) {
                                    throw new Error('Erro de rede ao buscar CEP. Status: ' + response.status);
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log("Dados da API ViaCEP:", data);
                                if (!data.erro) {
                                    streetInput.value = data.logradouro || '';
                                    bairroInput.value = data.bairro || '';
                                    cityInput.value = data.localidade || '';
                                    stateInput.value = data.uf || '';
                                    document.getElementById('street_number').focus();
                                    console.log("Campos de endereço preenchidos com sucesso.");
                                } else {
                                    alert('CEP não encontrado na base de dados ViaCEP.');
                                    streetInput.value = ''; bairroInput.value = ''; cityInput.value = ''; stateInput.value = '';
                                }
                            })
                            .catch(error => {
                                console.error('ERRO CRÍTICO NA BUSCA DO CEP:', error);
                                alert('Ocorreu um erro ao buscar o CEP. Verifique o console (F12) para mais detalhes.');
                                streetInput.value = ''; bairroInput.value = ''; cityInput.value = ''; stateInput.value = '';
                            });
                    } else if (cepValue.length > 0) {
                        console.warn("CEP digitado é inválido (não tem 8 dígitos):", cepValue);
                    } else {
                        console.log("Campo CEP ficou vazio.");
                    }
                });
            } else {
                console.error("ERRO CRÍTICO: Campo com id='cep' NÃO encontrado! A busca não funcionará.");
            }
        }); // Fim do DOMContentLoaded
    </script>
</x-app-layout>