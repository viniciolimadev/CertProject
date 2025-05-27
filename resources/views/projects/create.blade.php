{{-- resources/views/projects/create.blade.php --}}

<x-app-layout>
    {{-- Slot para o Cabeçalho --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Projeto') }}
        </h2>
    </x-slot>

    {{-- Contêiner principal da Página --}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Cartão branco para o formulário --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">

                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Adicionar Novo Projeto</h2>

                    {{-- Bloco para Exibição de Erros de Validação --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded" role="alert">
                            <div class="font-bold">Oops! Algo deu errado.</div>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulário de Criação --}}
                    {{-- Note: não precisa de enctype="multipart/form-data" aqui --}}
                    <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
                        @csrf {{-- Token CSRF essencial para segurança --}}

                        {{-- Campo: Nome do Projeto --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Projeto *</label>
                            <input type="text" name="name" id="name"
                                   @class([
                                       'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                       'border-red-500' => $errors->has('name'),
                                       'border-gray-300' => !$errors->has('name'),
                                   ])
                                   value="{{ old('name') }}" required placeholder="Ex: Meu Portfólio Incrível">
                            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campo: Descrição --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição (Opcional)</label>
                            <textarea name="description" id="description" rows="4"
                                      @class([
                                          'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                          'border-red-500' => $errors->has('description'),
                                          'border-gray-300' => !$errors->has('description'),
                                      ])
                                      placeholder="Descreva brevemente seu projeto, tecnologias usadas, etc.">{{ old('description') }}</textarea>
                            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campo: URL do Projeto --}}
                        <div>
                            <label for="url_project" class="block text-sm font-medium text-gray-700 mb-1">URL do Projeto (Opcional)</label>
                            <input type="url" name="url_project" id="url_project"
                                   @class([
                                       'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                       'border-red-500' => $errors->has('url_project'),
                                       'border-gray-300' => !$errors->has('url_project'),
                                   ])
                                   value="{{ old('url_project') }}" placeholder="https://meuprojeto.com ou https://github.com/...">
                            @error('url_project') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campo: Público --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Visibilidade *</label>
                            <div class="flex items-center">
                                {{-- Input escondido para garantir que '0' seja enviado se não marcado --}}
                                <input type="hidden" name="public" value="0">
                                <input type="checkbox" name="public" id="public" value="1"
                                       @checked(old('public', false)) {{-- Usa old() e @checked para manter o estado --}}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded @error('public') ring-2 ring-red-500 @enderror">
                                <label for="public" class="ml-2 block text-sm text-gray-900">
                                    Tornar este projeto público?
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Projetos públicos poderão ser vistos por outros usuários na plataforma.</p>
                            @error('public') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>


                        {{-- Botões de Ação --}}
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                             <a href="{{ route('projects.index') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Voltar
                            </a>
                            <x-primary-button>
                                {{ __('Salvar Projeto') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>