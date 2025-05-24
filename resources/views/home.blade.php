<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">

                    <h1 class="text-3xl font-bold mb-6 text-gray-800">Bem-vindo, {{ auth()->user()->name }}!</h1>

                    <hr class="my-8 border-gray-300">

                    {{-- Informações Pessoais --}}
                    <section class="mb-10">
                        <h2 class="text-2xl font-semibold mb-5 text-gray-700">Informações Pessoais</h2>
                        <div class="bg-gray-50 shadow-lg rounded-xl p-6 md:p-8">
                            <div class="md:flex md:items-start">
                                @if (!empty($profile->photo_path))
                                    <div class="md:w-1/4 text-center mb-6 md:mb-0 md:mr-8">
                                        <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto de {{ auth()->user()->name }}"
                                            class="w-32 h-40 object-cover rounded-lg shadow-md mx-auto border-2 border-white">
                                    </div>
                                @endif
                                <div class="{{ !empty($profile->photo_path) ? 'md:w-3/4' : 'w-full' }} space-y-3 text-gray-700">
                                    <p><strong class="font-medium text-gray-900">Nome:</strong> {{ auth()->user()->name }}</p>
                                    <p><strong class="font-medium text-gray-900">Telefone:</strong> {{ $profile->phone ?? 'Não informado' }}</p>
                                    <p><strong class="font-medium text-gray-900">Cidade:</strong> {{ $profile->city ?? 'Não informado' }}</p>
                                    <p><strong class="font-medium text-gray-900">Estado:</strong> {{ $profile->state ?? 'Não informado' }}</p>
                                    <p><strong class="font-medium text-gray-900">E-mail:</strong> <a href="mailto:{{ auth()->user()->email }}" class="text-blue-600 hover:underline">{{ auth()->user()->email }}</a></p>
                                    <div>
                                        <strong class="font-medium text-gray-900">Redes Sociais:</strong>
                                        @if (!empty($profile->social_links) && is_array($profile->social_links) && count($profile->social_links) > 0)
                                            <ul class="mt-1 list-disc list-inside pl-5">
                                                @foreach ($profile->social_links as $link)
                                                    @if(!empty(trim($link)))
                                                        <li><a href="{{ trim($link) }}" target="_blank" class="text-blue-600 hover:underline">{{ trim($link) }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="ml-2 text-gray-500">Não informado</span>
                                        @endif
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </section>

                    <hr class="my-10 border-gray-300">

                    {{-- Formações Acadêmicas --}}
                    <section class="mb-10">
                        <h2 class="text-2xl font-semibold mb-5 text-gray-700">Formações Acadêmicas</h2>
                        @if ($educations->isEmpty())
                            <p class="text-gray-500">Sem formações cadastradas.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($educations as $edu)
                                    <div class="bg-white shadow-lg rounded-xl p-5 flex flex-col h-full border border-gray-200">
                                        <h5 class="text-lg font-bold text-gray-800 mb-1">{{ $edu->degree }}</h5>
                                        <p class="text-gray-600 text-sm mb-2">{{ $edu->institution }}</p>
                                        <small class="text-gray-500 text-xs mt-auto">
                                            {{ $edu->start_date ? \Carbon\Carbon::parse($edu->start_date)->isoFormat('MMM YYYY') : 'N/A' }}
                                            —
                                            {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->isoFormat('MMM YYYY') : 'Atual' }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>

                    <hr class="my-10 border-gray-300">

                    {{-- Certificados --}}
                    <section class="mb-10">
                        <h2 class="text-2xl font-semibold mb-5 text-gray-700">Certificados</h2>
                        @if ($certificates->isEmpty())
                            <p class="text-gray-500">Sem certificados cadastrados.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($certificates as $certificate)
                                    <div class="bg-white shadow-lg rounded-xl flex flex-col h-[350px] border border-gray-200">
                                        <div class="p-5 flex-grow flex flex-col">
                                            <h5 class="text-lg font-bold text-gray-800 mb-1">{{ $certificate->title }}</h5>
                                            <p class="text-gray-600 text-sm mb-3 h-12 overflow-hidden"> {{-- Simula 3 linhas de texto --}}
                                                {{ $certificate->description_certificate }}
                                            </p>
                                            <div class="flex-grow mb-3 bg-gray-100 rounded flex items-center justify-center min-h-[160px]">
                                                <embed src="{{ asset('storage/' . $certificate->file_path) }}" width="100%" height="100%" type="application/pdf" class="rounded">
                                            </div>
                                        </div>
                                        <div class="p-5 border-t border-gray-200">
                                            <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank"
                                                class="block w-full text-center px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-600 hover:text-white text-sm font-medium transition duration-150 ease-in-out">
                                                Abrir em nova aba
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>

                    <hr class="my-10 border-gray-300">

                    {{-- Experiências --}}
                    <section class="mb-10">
                        <h2 class="text-2xl font-semibold mb-5 text-gray-700">Experiências Profissionais</h2>
                        @if ($experiences->isEmpty())
                            <p class="text-gray-500">Sem experiências profissionais cadastradas.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($experiences as $experience)
                                    <div class="bg-white shadow-lg rounded-xl p-5 flex flex-col h-full border border-gray-200">
                                        <h5 class="text-lg font-bold text-gray-800 mb-1">{{ $experience->position }} — <strong class="font-medium">{{ $experience->company }}</strong></h5>
                                        @if ($experience->description)
                                            <p class="text-gray-600 text-sm mb-2 flex-grow h-16 overflow-hidden"> {{-- Simula 3-4 linhas --}}
                                                {{ $experience->description }}
                                            </p>
                                        @else
                                            <div class="flex-grow"></div> {{-- Para manter alinhamento se não houver descrição --}}
                                        @endif
                                        <small class="text-gray-500 text-xs mt-auto">
                                            {{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->isoFormat('MMM YYYY') : 'N/A' }}
                                            —
                                            {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->isoFormat('MMM YYYY') : 'Atual' }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>

                    <hr class="my-10 border-gray-300">

                    {{-- Projetos --}}
                    <section>
                        <h2 class="text-2xl font-semibold mb-5 text-gray-700">Projetos</h2>
                        @if ($projects->isEmpty())
                            <p class="text-gray-500">Sem projetos cadastrados.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($projects as $project)
                                    <div class="bg-white shadow-lg rounded-xl flex flex-col h-[280px] border border-gray-200"> {{-- Altura ajustada --}}
                                        <div class="p-5 flex-grow flex flex-col">
                                            <h5 class="text-lg font-bold text-gray-800 mb-1">{{ $project->name }}</h5>
                                            @if ($project->description)
                                                <p class="text-gray-600 text-sm mb-3 flex-grow h-16 overflow-hidden"> {{-- Simula 3-4 linhas --}}
                                                    {{ $project->description }}
                                                </p>
                                            @endif
                                        </div>
                                        @if ($project->url_project)
                                            <div class="p-5 border-t border-gray-200">
                                                <a href="{{ $project->url_project }}" target="_blank"
                                                    class="block w-full text-center px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-600 hover:text-white text-sm font-medium transition duration-150 ease-in-out">
                                                    Abrir projeto
                                                </a>
                                            </div>
                                        @else
                                             <div class="p-5 border-t border-gray-200">
                                                <span class="block w-full text-center px-4 py-2 border border-gray-300 text-gray-400 rounded-md text-sm font-medium">
                                                    Sem link disponível
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
