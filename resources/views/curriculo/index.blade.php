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

                    {{-- Data de Nascimento e Idade --}}
                    @if ($profile->date_of_birth)
                        <p><strong class="font-medium text-gray-900">Data de Nascimento:</strong> {{ $profile->date_of_birth->isoFormat('DD/MM/YYYY') }} ({{ $profile->date_of_birth->age }} anos)</p>
                    @endif

                    {{-- Estado Civil --}}
                    @if ($profile->marital_status)
                        <p><strong class="font-medium text-gray-900">Estado Civil:</strong> {{ $profile->marital_status }}</p>
                    @endif

                    {{-- Endereço Completo --}}
                    <p><strong class="font-medium text-gray-900">Endereço:</strong>
                        {{ $profile->street_name ?? 'Rua não informada' }}{{ $profile->street_number ? ', ' . $profile->street_number : ', S/N' }}
                        @if($profile->address_complement), {{ $profile->address_complement }}@endif
                        <br>
                        {{ $profile->bairro ?? 'Bairro não informado' }} - {{ $profile->city ?? 'Cidade não informada' }},
                        {{ $profile->state ?? 'UF' }}
                        @if($profile->cep)<br>CEP: {{ $profile->cep }}@endif
                    </p>

                    <p><strong class="font-medium text-gray-900">Telefone:</strong> {{ $profile->phone ?? 'Não informado' }}</p>
                    <p><strong class="font-medium text-gray-900">Email:</strong> <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $user->email }}</a></p>

                    {{-- Redes Sociais Refatoradas --}}
                    @if (!empty($profile->social_links))
                        <div class="mt-3">
                            <strong class="font-medium text-gray-900 block mb-1">Redes Sociais:</strong> 
                            <ul class="list-none pl-0 space-y-1">
                                @php
                                    $linksArray = [];
                                    if (is_string($profile->social_links)) {
                                        $linksArray = array_filter(array_map('trim', explode(',', $profile->social_links)));
                                    } elseif (is_array($profile->social_links)) {
                                        $linksArray = array_filter(array_map('trim', $profile->social_links));
                                    }
                                @endphp
                                @foreach ($linksArray as $link)
                                    @php
                                        $trimmedLink = $link;
                                        $displayName = $trimmedLink;
                                        $urlHost = parse_url($trimmedLink, PHP_URL_HOST);
                                        if ($urlHost) {
                                            $urlHost = str_replace('www.', '', $urlHost);
                                            if (stripos($urlHost, 'linkedin.com') !== false) $displayName = 'LinkedIn';
                                            elseif (stripos($urlHost, 'github.com') !== false) $displayName = 'GitHub';
                                            elseif (stripos($urlHost, 'twitter.com') !== false || stripos($urlHost, 'x.com') !== false) $displayName = 'Twitter/X';
                                            elseif (stripos($urlHost, 'facebook.com') !== false) $displayName = 'Facebook';
                                            elseif (stripos($urlHost, 'instagram.com') !== false) $displayName = 'Instagram';
                                            elseif (stripos($urlHost, 'behance.net') !== false) $displayName = 'Behance';
                                            elseif (stripos($urlHost, 'dribbble.com') !== false) $displayName = 'Dribbble';
                                            else { $domainParts = explode('.', $urlHost); $displayName = ucfirst($domainParts[0]); }
                                        } else { $displayName = "Link"; }
                                    @endphp
                                    <li><a href="{{ $trimmedLink }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $displayName }}</a></li>
                                @endforeach
                            </ul>
                        </div>
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
                                <p class="mt-1 text-gray-600">{{ \Illuminate\Support\Str::limit($project->description, 180, '...') }}</p>
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
