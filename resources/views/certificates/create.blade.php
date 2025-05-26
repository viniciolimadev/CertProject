{{-- resources/views/certificates/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Certificado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">

                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Adicionar Novo Certificado</h2>

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

                    <form method="POST" action="{{ route('certificates.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Campo: Título --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                            <input type="text" name="title" id="title"
                                   @class([
                                       'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                       'border-red-500' => $errors->has('title'),
                                       'border-gray-300' => !$errors->has('title'),
                                   ])
                                   value="{{ old('title') }}" required>
                            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campo: Arquivo PDF --}}
                        <div>
                            <label for="file_path" class="block text-sm font-medium text-gray-700 mb-1">Arquivo PDF *</label>
                            <input type="file" name="file_path" id="file_path"
                                   @class([
                                       'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0',
                                       'file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100',
                                       'p-2 border rounded-md cursor-pointer',
                                       'border-red-500' => $errors->has('file_path'),
                                       'border-gray-300' => !$errors->has('file_path'),
                                   ])
                                   accept="application/pdf" required>
                             @error('file_path') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                             <p class="mt-1 text-xs text-gray-500">Apenas arquivos .pdf são permitidos.</p>
                        </div>

                        {{-- Campo: Descrição --}}
                        <div>
                            <label for="description_certificate" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                            <textarea name="description_certificate" id="description_certificate" rows="4"
                                      @class([
                                          'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                          'border-red-500' => $errors->has('description_certificate'),
                                          'border-gray-300' => !$errors->has('description_certificate'),
                                      ])>{{ old('description_certificate') }}</textarea>
                            @error('description_certificate') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campos: Datas (Início e Término) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Início (Opcional)</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                       @class([
                                           'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                           'border-red-500' => $errors->has('start_date'),
                                           'border-gray-300' => !$errors->has('start_date'),
                                       ])>
                                @error('start_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Término (Opcional)</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                       @class([
                                           'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                           'border-red-500' => $errors->has('end_date'),
                                           'border-gray-300' => !$errors->has('end_date'),
                                       ])>
                                @error('end_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Campo: Duração --}}
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duração (Opcional)</label>
                            <input type="text" name="duration" id="duration" value="{{ old('duration') }}"
                                   @class([
                                       'mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                                       'border-red-500' => $errors->has('duration'),
                                       'border-gray-300' => !$errors->has('duration'),
                                   ])
                                   placeholder="Ex: 40 horas ou 6 meses">
                            @error('duration') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Botão de Submissão --}}
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                             <a href="{{ route('certificates.index') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Voltar
                            </a>
                            <x-primary-button>
                                {{ __('Salvar Certificado') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const fileInput = document.getElementById('file_path');
        const titleInput = document.getElementById('title');

        if (fileInput && titleInput) {
            fileInput.addEventListener('change', () => {
                const file = fileInput.files[0];
                if (file) {
                    const filename = file.name.replace(/\.pdf$/i, '');
                    if (!titleInput.value) {
                        titleInput.value = filename;
                    }
                }
            });
        }
    </script>
    @endpush
</x-app-layout>