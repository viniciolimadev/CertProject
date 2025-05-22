@extends('auth.layout')

@section('title', 'Registrar')

@section('content')

{{-- Exibe mensagens de erro --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" name="password" type="password" required class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required class="form-control">
    </div>

    <button type="submit" class="btn btn-success w-100">Registrar</button>
</form>
@endsection

@section('links')
    <a href="{{ route('login') }}" class="link-primary">Já tem conta? Entrar</a>
@endsection
