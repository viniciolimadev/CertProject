<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Currículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Main content area for the resume --}}
            <div class="bg-white shadow-xl rounded-lg p-8 md:p-12 print:shadow-none print:p-0">
                {{-- Centralized Title --}}
                <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-10 print:mb-6">Currículo de {{ $user->name }}</h1>

                {{-- User Photo --}}
                @if(!empty($profile->photo_path))
                <div class="mb-10 text-center print:mb-6">
                    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto de {{ $user->name }}" class="w-32 h-32 md:w-36 md:h-36 object-cover rounded-full shadow-md inline-block border-4 border-white">
                </div>
                @endif

                {{-- Personal Data Section --}}
                <section class="mb-8 print:mb-6">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-700 border-b-2 border-gray-300 pb-2 mb-4 print:border-gray-500">Dados Pessoais</h2>
                    <div class="space-y-2 text-sm md:text-base text-gray-700">
                        <p><strong class="font-medium text-gray-900">Nome completo:</strong> {{ $user->name }}</p>
                        <p><strong class="font-medium text-gray-900">Endereço:</strong> {{ $profile->city ?? 'Cidade não informada' }}, {{ $profile->state ?? 'Estado não informado' }}</p>
                        <p><strong class="font-medium text-gray-900">Telefone:</strong> {{ $profile->phone ?? 'Não informado' }}</p>
                        <p><strong class="font-medium text-gray-900">Email:</strong> <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $user->email }}</a></p>
                        @if(!empty($profile->social_links))
                            <div>
                                <strong class="font-medium text-gray-900">Redes Sociais:</strong>
                                <span class="ml-2">
                                @php
                                    $links = is_array($profile->social_links) ? $profile->social_links : explode(',', $profile->social_links);
                                @endphp
                                @foreach($links as $link)
                                    <a href="{{ trim($link) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">{{ trim($link) }}</a>@if(!$loop->last), @endif
                                @endforeach
                                </span>
                            </p>
                        @endif
                    </div>
                </section>

                {{-- Education Section --}}
                <section class="mb-8 print:mb-6">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-700 border-b-2 border-gray-300 pb-2 mb-4 print:border-gray-500">Formações</h2>
                    <div class="space-y-4 text-sm md:text-base text-gray-700">
                        @forelse($educations as $education)
                            <div>
                                <p><strong class="font-medium text-gray-900">{{ $education->degree }}</strong> — {{ $education->institution }}</p>
                                <p class="text-xs md:text-sm text-gray-500">
                                    {{ $education->start_date ? \Carbon\Carbon::parse($education->start_date)->isoFormat('MMM YYYY') : 'Início indefinido' }}
                                    - {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->isoFormat('MMM YYYY') : 'Atual' }}
                                </p>
                            </div>
                        @empty
                            <p>Sem formações registradas.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Experiences Section --}}
                <section class="mb-8 print:mb-6">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-700 border-b-2 border-gray-300 pb-2 mb-4 print:border-gray-500">Experiências</h2>
                    <div class="space-y-4 text-sm md:text-base text-gray-700">
                        @forelse($experiences as $experience)
                            <div>
                                <p><strong class="font-medium text-gray-900">{{ $experience->position }}</strong> em {{ $experience->company }}</p>
                                <p class="text-xs md:text-sm text-gray-500">
                                    {{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->isoFormat('MMM YYYY') : 'Início indefinido' }}
                                    - {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->isoFormat('MMM YYYY') : 'Atual' }}
                                </p>
                                @if($experience->description)
                                <p class="mt-1 text-gray-600">{{ $experience->description }}</p>
                                @endif
                            </div>
                        @empty
                            <p>Sem experiências registradas.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Certificates Section --}}
                <section class="mb-8 print:mb-6">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-700 border-b-2 border-gray-300 pb-2 mb-4 print:border-gray-500">Certificados</h2>
                    <div class="space-y-4 text-sm md:text-base text-gray-700">
                        @forelse($certificates as $certificate)
                            <div>
                                <p><strong class="font-medium text-gray-900">{{ $certificate->title }}</strong></p>
                                @if($certificate->description_certificate)
                                <p class="mt-1 text-gray-600">{{ $certificate->description_certificate }}</p>
                                @endif
                            </div>
                        @empty
                            <p>Sem certificados.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Projects Section --}}
                <section class="mb-8 print:mb-6">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-700 border-b-2 border-gray-300 pb-2 mb-4 print:border-gray-500">Projetos</h2>
                    <div class="space-y-4 text-sm md:text-base text-gray-700">
                        @forelse($projects as $project)
                            <div>
                                <p><strong class="font-medium text-gray-900">{{ $project->name }}</strong></p>
                                @if($project->description)
                                <p class="mt-1 text-gray-600">{{ $project->description }}</p>
                                @endif
                                @if($project->url_project)
                                    <p class="mt-1"><a href="{{ $project->url_project }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $project->url_project }}</a></p>
                                @endif
                            </div>
                        @empty
                            <p>Sem projetos.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Download Button Container --}}
            <div class="mt-10 mb-12 text-center print:hidden">
                <a href="{{ route('curriculo.export') }}" target="_blank" class="inline-flex items-center px-8 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Baixar Currículo em PDF
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
