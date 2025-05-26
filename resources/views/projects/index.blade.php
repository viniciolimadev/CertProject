<x-app-layout> {{-- Alterado de @extends('layout') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projetos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-700">Projetos</h1>
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Novo Projeto
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 rounded relative bg-green-100 border border-green-400 text-green-700" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($projects->isEmpty())
                        <p class="text-gray-600">Nenhum projeto cadastrado.</p>
                    @else
                        <ul class="space-y-6">
                            @foreach ($projects as $project)
                                <li class="bg-white shadow-lg rounded-xl p-5 border border-gray-200">
                                    <div class="flex flex-col sm:flex-row justify-between">
                                        <div class="mb-4 sm:mb-0">
                                            <h5 class="text-lg font-bold text-gray-800">{{ $project->name }}</h5>
                                            @if($project->description)
                                            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($project->description, 200) }}</p>
                                            @endif
                                            @if($project->public)
                                                <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Público
                                                </span>
                                            @else
                                                <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Privado
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0 flex flex-col sm:flex-row sm:items-center gap-2">
                                            @if($project->url_project)
                                                <a href="{{ $project->url_project }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white text-sm font-medium transition duration-150 ease-in-out">
                                                    Acessar Projeto
                                                </a>
                                            @endif
                                            {{-- Adicionar botão de editar se necessário --}}
                                            {{-- <a href="{{ route('projects.edit', $project->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm font-medium transition duration-150 ease-in-out">
                                                Editar
                                            </a> --}}
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este projeto?')" class="w-full sm:w-auto">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>