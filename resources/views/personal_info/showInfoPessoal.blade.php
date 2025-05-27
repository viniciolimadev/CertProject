<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Dados Pessoais') }}
            </h2>
            <a href="{{ route('personal_info.edit') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Editar Dados') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200 text-gray-700">

                    <div class="md:flex md:items-start">
                        {{-- Coluna da Foto --}}
                        @if ($profile->photo_path)
                            <div class="md:w-1/4 text-center md:text-left mb-6 md:mb-0 md:mr-8 flex-shrink-0">
                                <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto de {{ $user->name }}"
                                     class="w-32 h-auto md:w-40 object-cover rounded-lg shadow-lg mx-auto md:mx-0 border-2 border-gray-200">
                            </div>
                        @else
                            <div class="md:w-1/4 text-center md:text-left mb-6 md:mb-0 md:mr-8 flex-shrink-0">
                                <div class="w-32 h-40 md:w-40 bg-gray-100 rounded-lg shadow-md mx-auto md:mx-0 flex items-center justify-center text-gray-500 border-2 border-gray-200">
                                    Sem foto
                                </div>
                            </div>
                        @endif

                        {{-- Coluna das Informações --}}
                        <div class="{{ $profile->photo_path ? 'md:w-3/4' : 'w-full' }}">
                            <h3 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-4">{{ $user->name }}</h3>

                            <div class="space-y-3 text-sm">
                                @if ($profile->date_of_birth)
                                    <p><strong class="font-medium text-gray-900">Nascimento:</strong> {{ $profile->date_of_birth->isoFormat('DD/MM/YYYY') }} ({{ $profile->date_of_birth->age }} anos)</p>
                                @endif

                                <p><strong class="font-medium text-gray-900">Nacionalidade:</strong> {{ $profile->nationality ?? 'Não informada' }}</p>
                                <p><strong class="font-medium text-gray-900">Estado Civil:</strong> {{ $profile->marital_status ?? 'Não informado' }}</p>
                                <p><strong class="font-medium text-gray-900">Telefone:</strong> {{ $profile->phone ?? 'Não informado' }}</p>
                                <p><strong class="font-medium text-gray-900">E-mail:</strong> <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:underline">{{ $user->email }}</a></p>

                                <div class="pt-1">
                                    <strong class="font-medium text-gray-900">Endereço:</strong>
                                    <address class="not-italic mt-1">
                                        {{ $profile->street_name ?? 'Rua não informada' }}{{ $profile->street_number ? ', ' . $profile->street_number : '' }}
                                        @if($profile->address_complement), {{ $profile->address_complement }}@endif
                                        <br>
                                        {{ $profile->bairro ?? 'Bairro não informado' }}
                                        <br>
                                        {{ $profile->city ?? 'Cidade não informada' }} - {{ $profile->state ?? 'UF' }}
                                        @if($profile->cep)<br>CEP: {{ $profile->cep }}@endif
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($profile->about_me)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Sobre Mim</h4>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $profile->about_me }}</p>
                    </div>
                    @endif

                    @php
                        $linksArray = [];
                        if (!empty($profile->social_links)) {
                            if (is_string($profile->social_links)) {
                                $linksArray = array_filter(array_map('trim', explode(',', $profile->social_links)));
                            } elseif (is_array($profile->social_links)) {
                                $linksArray = array_filter(array_map('trim', $profile->social_links));
                            }
                        }
                    @endphp
                    @if (count($linksArray) > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Redes Sociais</h4>
                        <ul class="list-none pl-0 space-y-1 text-sm">
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
                                        else { $domainParts = explode('.', $urlHost); $displayName = ucfirst($domainParts[0]); }
                                    } else { $displayName = "Link"; }
                                @endphp
                                <li><a href="{{ $trimmedLink }}" target="_blank" class="text-blue-600 hover:underline">{{ $displayName }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>