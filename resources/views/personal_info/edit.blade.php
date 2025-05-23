@extends('layout')

@section('title', 'Editar Dados Pessoais')

@section('content')
    <div class="container mt-4">
        <h1>Editar Dados Pessoais</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('personal_info.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="photo" class="form-label">Foto de Perfil:</label>
                <input type="file" id="photo" name="photo" class="form-control">
                @if (!empty($profile->photo_path))
                    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto atual"
                        style="max-width: 150px; margin-top: 10px;">
                @endif
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name', auth()->user()->name) }}">
            </div>

            <div class="mb-3">
    <label for="phone" class="form-label">Telefone:</label>
    <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" maxlength="17" placeholder="+55 85 99999-9999">
</div>

<script>
    const phoneInput = document.getElementById('phone');

    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

        if (value.startsWith('55')) {
            value = value.substring(2); // remove o DDI se já foi digitado
        }

        // Adiciona +55 no começo sempre
        let formatted = '+55 ';

        if(value.length > 0) {
            formatted += value.substring(0, 2); // DDD
        }
        if(value.length >= 3) {
            formatted += ' ' + value.substring(2, 7); // primeiros 5 dígitos do número
        }
        if(value.length >= 8) {
            formatted += '-' + value.substring(7, 11); // últimos 4 dígitos
        }

        e.target.value = formatted;
    });
</script>


            <div class="mb-3">
                <label for="city" class="form-label">Cidade:</label>
                <input type="text" id="city" name="city" class="form-control"
                    value="{{ old('city', $profile->city) }}">
            </div>

            <div class="mb-3">
                <label for="state" class="form-label">Estado:</label>
                <input type="text" id="state" name="state" class="form-control"
                    value="{{ old('state', $profile->state) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', $profile->email) }}">
            </div>

            <div class="mb-3">
                <label for="social_links" class="form-label">Redes Sociais (separadas por vírgula):</label>
                <textarea id="social_links" name="social_links" class="form-control" rows="3">{{ old('social_links', is_array($profile->social_links) ? implode(', ', $profile->social_links) : '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
