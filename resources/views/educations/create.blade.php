<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adicionar Nova Formação Acadêmica') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Adicionar Formação</h1>

                    {{-- Exibir erros de validação, se houver --}}
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

                    <form method="POST" action="{{ route('educations.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="degree" class="block text-sm font-medium text-gray-700 mb-1">Graduação/Curso</label>
                            <input type="text" name="degree" id="degree" value="{{ old('degree') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            {{-- @error('degree') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div>
                            <label for="institution" class="block text-sm font-medium text-gray-700 mb-1">Instituição</label>
                            <input type="text" name="institution" id="institution" value="{{ old('institution') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            {{-- @error('institution') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Início</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                {{-- @error('start_date') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Conclusão / Previsão</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                {{-- @error('end_date') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror --}}
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Formação
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
