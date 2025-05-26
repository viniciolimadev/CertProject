{{-- resources/views/certificates/index.blade.php --}}

<x-app-layout>
    {{-- Slot para o Cabeçalho --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Certificados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo Principal da Página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Exibição de Mensagens de Sucesso --}}
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                            <p class="font-bold">Sucesso!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Botão para Adicionar Novo Certificado --}}
                    <div class="mb-6">
                        <a href="{{ route('certificates.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center shadow-md transition duration-300 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Adicionar Novo Certificado
                        </a>
                    </div>

                    {{-- Verificação e Listagem de Certificados --}}
                    @if ($certificates->isEmpty())
                        {{-- Mensagem caso não haja certificados --}}
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md" role="alert">
                            <p>Você ainda não adicionou nenhum certificado.</p>
                        </div>
                    @else
                        {{-- Lista de Certificados como Cartões --}}
                        <div class="space-y-6">
                            @foreach ($certificates as $certificate)
                                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-200 flex flex-col">

                                    {{-- Seção de Pré-visualização --}}
                                    <div class="mb-4 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center min-h-[250px] overflow-hidden">
                                        @if(Storage::disk('public')->exists($certificate->file_path))
                                            <embed src="{{ asset('storage/' . $certificate->file_path) }}#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="300px" type="application/pdf" class="rounded-md">
                                        @else
                                            <div class="text-center text-gray-500 p-4">
                                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <span>Pré-visualização indisponível.</span>
                                            </div>
                                        @endif {{-- Fim do @if interno --}}
                                    </div>

                                    {{-- Conteúdo (Título, Descrição, Datas) --}}
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                                        <h3 class="text-xl font-semibold text-gray-900 mb-1 sm:mb-0">{{ $certificate->title }}</h3>
                                        <span class="text-sm text-gray-500 flex-shrink-0">Adicionado em: {{ $certificate->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="text-gray-700 mb-3">{{ $certificate->description_certificate }}</p>
                                    <div class="text-sm text-gray-600 mb-4 flex flex-wrap gap-x-4 gap-y-1">
                                        @if ($certificate->start_date)
                                            <span>Início: <span class="font-medium">{{ \Carbon\Carbon::parse($certificate->start_date)->format('d/m/Y') }}</span></span>
                                        @endif
                                        @if ($certificate->end_date)
                                            <span>Fim: <span class="font-medium">{{ \Carbon\Carbon::parse($certificate->end_date)->format('d/m/Y') }}</span></span>
                                        @endif
                                        @if ($certificate->duration)
                                            <span>Duração: <span class="font-medium">{{ $certificate->duration }} horas</span></span>
                                        @endif
                                    </div>

                                    {{-- Botões de Ação --}}
                                    <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-gray-100">
                                        <a href="{{ route('certificates.viewPdf', $certificate) }}" target="_blank" class="bg-teal-500 hover:bg-teal-600 text-white font-medium py-1 px-3 rounded-md text-sm inline-flex items-center shadow-sm transition duration-300">
                                           <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                           Ver em Nova Aba
                                        </a>
                                        <a href="{{ route('certificates.download', $certificate) }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-1 px-3 rounded-md text-sm inline-flex items-center shadow-sm transition duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                           Baixar
                                        </a>
                                        <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded-md text-sm inline-flex items-center shadow-sm transition duration-300" onclick="return confirm('Tem certeza que deseja excluir este certificado?')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                               Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif {{-- Fim do @if ($certificates->isEmpty()) --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>