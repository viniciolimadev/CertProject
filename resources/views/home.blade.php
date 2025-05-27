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
                    {{-- Seção Informações Pessoais --}}
                    {{-- Seção Informações Pessoais --}}
                    <section class="mb-10">
                        <h2 class="text-2xl font-semibold mb-5 text-gray-700">Informações Pessoais</h2>
                        <div class="bg-gray-50 shadow-lg rounded-xl p-6 md:p-8">
                            {{-- Container Flex principal: Foto | Informações --}}
                            {{-- md:items-center tentará centralizar verticalmente as duas colunas --}}
                            <div class="md:flex md:items-center">
                                @if (!empty($profile->photo_path))
                                    <div class="md:w-1/4 text-center mb-6 md:mb-0 md:mr-8 flex-shrink-0">
                                        <img src="{{ asset('storage/' . $profile->photo_path) }}"
                                            alt="Foto de {{ auth()->user()->name }}"
                                            class="w-32 h-40 object-cover rounded-lg shadow-md mx-auto border-2 border-white">
                                    </div>
                                @endif
                                {{-- Coluna das Informações --}}
                                <div class="{{ !empty($profile->photo_path) ? 'md:w-3/4' : 'w-full' }} text-gray-700">
                                    {{-- Nome do Usuário (Destaque) --}}
                                    <p class="text-xl lg:text-2xl font-bold text-gray-900 mb-3">
                                        {{ auth()->user()->name }}</p>

                                    {{-- Grid para informações pessoais em pares (md:grid-cols-2) --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-sm">

                                        {{-- Par 1: Nascimento --}}
                                        @if (!empty($profile->date_of_birth))
                                            <p><strong class="font-medium text-gray-800">Nascimento:</strong>
                                                {{ $profile->date_of_birth->isoFormat('DD/MM/YYYY') }}
                                                ({{ $profile->date_of_birth->age }} anos)</p>
                                        @else
                                            <p><strong class="font-medium text-gray-800">Nascimento:</strong> Não
                                                informado</p>
                                        @endif

                                        {{-- Par 1: Nacionalidade --}}
                                        <p><strong class="font-medium text-gray-800">Nacionalidade:</strong>
                                            {{ $profile->nationality ?? 'Não informada' }}</p>

                                        {{-- Par 2: Estado Civil --}}
                                        @if (!empty($profile->marital_status))
                                            <p><strong class="font-medium text-gray-800">Estado Civil:</strong>
                                                {{ $profile->marital_status }}</p>
                                        @else
                                            <p><strong class="font-medium text-gray-800">Estado Civil:</strong> Não
                                                informado</p>
                                        @endif

                                        {{-- Par 2: Telefone --}}
                                        <p><strong class="font-medium text-gray-800">Telefone:</strong>
                                            {{ $profile->phone ?? 'Não informado' }}</p>

                                        {{-- E-mail (ocupará a próxima célula disponível, pode ficar sozinho na linha 3 em telas md) --}}
                                        <p><strong class="font-medium text-gray-800">E-mail:</strong> <a
                                                href="mailto:{{ auth()->user()->email }}"
                                                class="text-blue-600 hover:underline">{{ auth()->user()->email }}</a>
                                        </p>

                                  

                                    {{-- Endereço (Bloco separado) --}}
                                    
                                        <strong class="font-medium text-gray-800">Endereço:</strong>
                                        <address class="not-italic">
                                            {{ $profile->street_name ?? 'Rua não informada' }}{{ !empty($profile->street_number) ? ', ' . !empty($profile->street_number) : '' }}
                                            @if (!empty($profile->address_complement))
                                                , {{ $profile->address_complement }}
                                            @endif
                                            <br>
                                            {{ $profile->bairro ?? 'Bairro não informado' }}<br>
                                            {{ $profile->city ?? 'Cidade não informada' }} -
                                            {{ $profile->state ?? 'UF' }}
                                            @if (!empty($profile->cep))
                                                <br>CEP: {{ $profile->cep }}
                                            @endif
                                        </address>

                                      {{-- Fim do Grid --}}

                                    {{-- Redes Sociais (Bloco separado com lista) --}}
                                    <div class="mt-3 text-sm">
                                        <strong class="font-medium text-gray-800 block mb-1">Redes Sociais:</strong>
                                        @php
                                            $linksArray = [];
                                            if (!empty($profile->social_links)) {
                                                if (is_string($profile->social_links)) {
                                                    $linksArray = array_filter(
                                                        array_map('trim', explode(',', $profile->social_links)),
                                                    );
                                                } elseif (is_array($profile->social_links)) {
                                                    $linksArray = array_filter(
                                                        array_map('trim', $profile->social_links),
                                                    );
                                                }
                                            }
                                        @endphp

                                        @if (count($linksArray) > 0)
                                            <ul class="list-none pl-0 space-y-1">
                                                @foreach ($linksArray as $link)
                                                    @php
                                                        $trimmedLink = $link;
                                                        $displayName = $trimmedLink;
                                                        $urlHost = parse_url($trimmedLink, PHP_URL_HOST);
                                                        if ($urlHost) {
                                                            $urlHost = str_replace('www.', '', $urlHost);
                                                            if (stripos($urlHost, 'linkedin.com') !== false) {
                                                                $displayName = 'LinkedIn';
                                                            } elseif (stripos($urlHost, 'github.com') !== false) {
                                                                $displayName = 'GitHub';
                                                            } elseif (
                                                                stripos($urlHost, 'twitter.com') !== false ||
                                                                stripos($urlHost, 'x.com') !== false
                                                            ) {
                                                                $displayName = 'Twitter/X';
                                                            } else {
                                                                $domainParts = explode('.', $urlHost);
                                                                $displayName = ucfirst($domainParts[0]);
                                                            }
                                                        } else {
                                                            $displayName = 'Link';
                                                        }
                                                    @endphp
                                                    <li><a href="{{ $trimmedLink }}" target="_blank"
                                                            class="text-blue-600 hover:underline">{{ $displayName }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-500">Não informado</span>
                                        @endif
                                    </div>
                                </div> {{-- Fim da Coluna das Informações --}}
                            </div> {{-- Fim do Container Flex --}}
                        </div> {{-- Fim do bg-gray-50 --}}
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
                                    <div
                                        class="bg-white shadow-lg rounded-xl p-5 flex flex-col h-full border border-gray-200">
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
                                    <div
                                        class="bg-white shadow-lg rounded-xl flex flex-col h-[500px] border border-gray-200">
                                        <div class="p-5 flex-grow flex flex-col ">
                                            <h5 class="text-lg font-bold text-gray-800 mb-1">{{ $certificate->title }}
                                            </h5>
                                            
                                            <p class="text-gray-600 text-sm mb-3 h-8 w-180 truncate text-ellipsis whitespace-nowrap">
                                                {{-- Simula 3 linhas de texto --}}
                                                {{ $certificate->description_certificate }}
                                            </p>
                                            <div
                                                class="flex-grow mb-3 bg-gray-100 rounded flex items-center justify-center min-h-[160px]">
                                                <embed src="{{ asset('storage/' . $certificate->file_path) }}"
                                                    width="100%" height="100%" type="application/pdf"
                                                    class="rounded">
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
                                    <div
                                        class="bg-white shadow-lg rounded-xl p-5 flex flex-col h-full border border-gray-200">
                                        <h5 class="text-lg font-bold text-gray-800 mb-1">{{ $experience->position }} —
                                            <strong class="font-medium">{{ $experience->company }}</strong>
                                        </h5>
                                        @if ($experience->description)
                                            <p class="text-gray-600 text-sm mb-2 flex-grow h-16 overflow-hidden">
                                                {{-- Simula 3-4 linhas --}}
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
                                    <div
                                        class="bg-white shadow-lg rounded-xl flex flex-col h-[280px] border border-gray-200">
                                        {{-- Altura ajustada --}}
                                        <div class="p-5 flex-grow flex flex-col">
                                            <h5 class="text-lg font-bold text-gray-800 mb-1">{{ $project->name }}</h5>
                                            @if ($project->description)
                                                <p class="text-gray-600 text-sm mb-3 flex-grow h-16 overflow-hidden">
                                                    {{-- Simula 3-4 linhas --}}
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
                                                <span
                                                    class="block w-full text-center px-4 py-2 border border-gray-300 text-gray-400 rounded-md text-sm font-medium">
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
