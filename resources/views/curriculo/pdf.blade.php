<!DOCTYPE html>
<html lang="pt-BR"> {{-- Definido para Português do Brasil --}}

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> {{-- Essencial para PDF e acentos --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currículo de {{ $user->name }}</title>

    <style>
        @page {
            margin: 20mm;
            /* Margens da página para impressão/PDF */
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            /* ESSENCIAL para acentos em PDF */
            font-size: 10pt;
            line-height: 1.4;
            color: #333333;
            /* Cor de texto principal */
            background-color: #ffffff;
            /* Fundo branco */
        }

        /* ----- CABEÇALHO PRINCIPAL (FOTO + INFOS) ----- */
        .header-section {
            margin-bottom: 8mm;
            /* Espaço após o bloco de cabeçalho */
            page-break-inside: avoid;
            /* Tenta evitar quebra de página dentro desta seção */
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            /* Remove espaços entre células */
        }

        .photo-cell {
            width: 35mm;
            /* Largura da coluna da foto (ajuste conforme necessário) */
            padding-right: 5mm;
            /* Espaço entre a foto e o texto */
            vertical-align: top;
            /* Alinha o conteúdo da célula ao topo */
        }

        /* Estilos para a imagem da foto e para o placeholder */
        .photo-cell img,
        .photo-cell .photo-placeholder {
            display: block;
            /* Remove espaço extra abaixo da imagem */
            width: 35mm;
            /* Largura da foto (deve ser igual à da célula se quiser ocupar tudo) */
            height: 45mm;
            /* Altura da foto - ESTA É A ALTURA DE REFERÊNCIA */
            object-fit: cover;
            /* Faz a imagem cobrir as dimensões sem distorcer */
            border-radius: 3mm;
            /* Cantos levemente arredondados */
            border: 0.5mm solid #cccccc;
            /* Borda sutil */
        }

        .photo-cell .photo-placeholder {
            /* Estilo para o div caso não haja foto */
            background-color: #f0f0f0;
            text-align: center;
            /* Para centralizar o texto "Foto" verticalmente: */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
            color: #aaaaaa;
        }

        .info-cell {
            /* A largura será o restante (100% - largura da photo-cell - padding-right da photo-cell) */
            /* Se width da photo-cell é 35mm e padding 5mm, a info-cell terá calc(100% - 40mm) */
            height: 45mm;
            /* <<< ALTURA EXATAMENTE IGUAL À DA FOTO */
            vertical-align: top;
            overflow: hidden;
            /* <<< CORTA QUALQUER TEXTO QUE ULTRAPASSAR ESTA ALTURA */
            padding: 0;
            /* Garante que o padding não interfira na altura do conteúdo */
        }

        .info-cell .name {
            font-size: 17pt;
            /* Nome destacado */
            font-weight: bold;
            margin-top: 0;
            /* Alinha com o topo da foto */
            margin-bottom: 2.5mm;
            /* Espaço abaixo do nome */
            color: #111111;
            /* Cor mais escura para o nome */
            line-height: 1.2;
            text-align: left;
        }

        .info-cell p {
            /* Parágrafos gerais dentro da info-cell */
            margin-top: 0;
            margin-bottom: 1.2mm;
            /* Espaçamento justo entre as linhas de informação */
            font-size: 9.5pt;
            line-height: 1.3;
            text-align: left;
        }

        .info-cell p strong {
            /* Rótulos como "Endereço:", "Telefone:" */
            font-weight: bold;
            color: #000000;
        }

        .info-cell a {
            /* Links dentro da info-cell */
            color: #0056b3;
            /* Azul padrão para links */
            text-decoration: none;
        }

        .info-cell a:hover {
            /* Apenas para visualização web, PDF não tem hover */
            text-decoration: underline;
        }

        /* Tabela aninhada para detalhes lado a lado dentro da info-cell */
        .info-cell .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5mm;
            /* Espaço após os pares de detalhes */
        }

        .info-cell .details-table td {
            width: 50%;
            /* Cada célula da tabela aninhada ocupa metade do espaço */
            vertical-align: top;
            padding-bottom: 1mm;
            /* Pequeno espaço abaixo de cada linha de par */
            padding-right: 2mm;
            /* Pequeno espaço à direita de cada célula interna, exceto a última */
        }

        .info-cell .details-table td:last-child {
            padding-right: 0;
            /* Remove padding da última célula da linha */
        }

        .info-cell .details-table p {
            /* Parágrafos dentro da tabela de detalhes */
            margin-bottom: 0.5mm;
            /* Margem ainda menor */
            line-height: 1.25;
        }


        /* ----- SEÇÕES GERAIS DO CURRÍCULO (Formação, Experiência, etc.) ----- */
        section {
            margin-top: 7mm;
            margin-bottom: 7mm;
            page-break-inside: avoid;
            /* Tenta evitar quebra de seção no PDF */
        }

        h2 {
            /* Títulos das seções: "Formação Acadêmica", "Experiência Profissional" */
            font-size: 14pt;
            font-weight: bold;
            color: #1a202c;
            /* Cor escura, pode ser #000 ou #222 */
            border-bottom: 0.7mm solid #4a5568;
            /* Linha separadora mais grossa e escura */
            padding-bottom: 2mm;
            margin-top: 0;
            /* A section já tem margem no topo */
            margin-bottom: 4mm;
            /* Espaço após o título da seção */
            page-break-after: avoid;
            /* Tenta não quebrar a página logo após um título de seção */
        }

        /* Entradas dentro das seções (cada curso, cada experiência) */
        .entry {
            margin-bottom: 4mm;
            page-break-inside: avoid;
        }

        .entry p {
            /* Parágrafos gerais dentro de uma entrada */
            margin-bottom: 1mm;
            font-size: 10pt;
            /* Mantém o tamanho padrão para o corpo do texto */
            text-align: left;
        }

        .entry p strong {
            /* Para destacar títulos de cargo, curso, instituição */
            font-weight: bold;
            color: #2d3748;
            /* Um pouco mais suave que preto puro */
        }

        .entry .date {
            /* Para as datas em cada entrada */
            font-size: 8.5pt;
            color: #718096;
            /* Cinza para as datas */
            margin-top: -0.5mm;
            /* Aproxima a data do item acima */
            margin-bottom: 1.5mm;
        }

        /* Para truncar descrições longas (melhor usar Str::limit no backend para PDF) */
        .description-truncate {
            font-size: 9.5pt;
            color: #4a5568;
            /* CSS line-clamp (funciona melhor em navegadores, PDF pode variar) */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Número de linhas desejado */
            -webkit-box-orient: vertical;
            /* max-height: 4.2em; /* (3 linhas * 1.4 line-height) - Alternativa para PDF se line-clamp falhar */
        }

        /* Utilidades */
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <section class="header-section">
        <table class="header-table">
            <tr>
                <td class="photo-cell">
                    @if ($profile->photo_path && file_exists(public_path('storage/' . $profile->photo_path)))
                        {{-- A tag img usará os estilos de .photo-cell img --}}
                        <img src="{{ public_path('storage/' . $profile->photo_path) }}"
                            alt="Foto de {{ $user->name }}">
                    @else
                        {{-- Placeholder simples se não houver foto --}}
                        <div class="photo-placeholder">Foto</div> {{-- Aplicada a classe CSS --}}
                    @endif
                </td>
                <td class="info-cell">
                    <p class="name">{{ $user->name }}</p>

                    {{-- Linha para Idade e Nacionalidade --}}
                    @if ($profile->date_of_birth || $profile->nationality)
                        <p>
                            @if ($profile->date_of_birth)
                                <span>{{ $profile->date_of_birth->age }} anos</span>
                            @endif
                            @if ($profile->date_of_birth && $profile->nationality)
                                <span> | </span> {{-- Separador apenas se ambos existirem --}}
                            @endif
                            @if ($profile->nationality)
                                <span>{{ $profile->nationality }}</span>
                            @endif
                        </p>
                    @endif

                    {{-- Endereço Condensado --}}
                    <p>
                        <strong>Endereço:</strong>
                        @php
                            $addressParts = [];
                            if (!empty($profile->street_name)) {
                                $addressParts[] =
                                    $profile->street_name .
                                    ($profile->street_number ? ', ' . $profile->street_number : '');
                            }
                            // O modelo de exemplo não mostra bairro ou complemento aqui para manter conciso.
                            if (!empty($profile->city)) {
                                $addressParts[] = $profile->city;
                            }
                            if (!empty($profile->state)) {
                                $addressParts[] = $profile->state;
                            }
                            // O modelo de exemplo tem "País", que não temos nos dados. Pode ser adicionado se necessário.
                            // if (!empty($profile->country)) {
                            //     $addressParts[] = $profile->country;
                            // }
                            echo implode(' - ', array_filter($addressParts));
                            if (empty(array_filter($addressParts))) {
                                echo 'Não informado';
                            }
                        @endphp
                    </p>

                    {{-- Telefone --}}
                    @if ($profile->phone)
                        <p><strong>Telefone:</strong> {{ $profile->phone }}</p>
                    @endif

                    {{-- Email --}}
                    <p><strong>Email:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>

                    {{-- Estado Civil e Redes Sociais foram OMITIDOS desta seção, conforme o modelo --}}
                </td>
            </tr>
        </table>
    </section>

    {{-- REMOVA o antigo h1 centralizado e a antiga seção "Dados Pessoais e Contato", pois foram incorporados acima --}}
    {{-- O @if ($profile->about_me) pode ser movido para uma nova seção "Sobre Mim" abaixo, se desejar --}}
    @if ($profile->about_me)
        <section>
            <h2>Sobre Mim</h2>
            <p>{{ $profile->about_me }}</p>
        </section>
    @endif

    {{-- FORMAÇÕES --}}
    <section>
        <h2>Formação Acadêmica</h2>
        @forelse($educations as $education)
            <div class="entry">
                <p><strong>{{ $education->degree }}</strong> - {{ $education->institution }}</p>
                <p class="date">
                    {{ $education->start_date ? \Carbon\Carbon::parse($education->start_date)->isoFormat('MMM[/]YYYY') : '?' }}
                    -
                    {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->isoFormat('MMM[/]YYYY') : 'Atual' }}
                </p>
            </div>
        @empty
            <p>Nenhuma formação acadêmica registrada.</p>
        @endforelse
    </section>

    {{-- EXPERIÊNCIAS --}}
    <section>
        <h2>Experiência Profissional</h2>
        @forelse($experiences as $experience)
            <div class="entry">
                <p><strong>{{ $experience->position }}</strong> - {{ $experience->company }}</p>
                <p class="date">
                    {{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->isoFormat('MMM[/]YYYY') : '?' }}
                    -
                    {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->isoFormat('MMM[/]YYYY') : 'Atual' }}
                </p>
                @if ($experience->description)
                    <p>{{ $experience->description }}</p>
                @endif
            </div>
        @empty
            <p>Nenhuma experiência profissional registrada.</p>
        @endforelse
    </section>

    {{-- CERTIFICADOS --}}
    <section>
        <h2>Certificados e Cursos</h2>
        @forelse($certificates as $certificate)
            <div class="entry">
                <p><strong>{{ $certificate->title }}</strong></p>
                @if ($certificate->description_certificate)
                    <p>{{ $certificate->description_certificate }}</p>
                @endif
            </div>
        @empty
            <p>Nenhum certificado registrado.</p>
        @endforelse
    </section>

    {{-- PROJETOS --}}
    <section>
        <h2>Projetos</h2>
        @forelse($projects as $project)
            <div class="entry">
                <p><strong>{{ $project->name }}</strong></p>
                @if ($project->description)
                    <p class="description-truncate">
                        {{ \Illuminate\Support\Str::limit(strip_tags($project->description), 180, '...') }}</p>
                @endif
                @if ($project->url_project)
                    <p><a href="{{ $project->url_project }}" target="_blank">{{ $project->url_project }}</a></p>
                @endif
            </div>
        @empty
            <p>Nenhum projeto registrado.</p>
        @endforelse
    </section>

</body>

</html>
