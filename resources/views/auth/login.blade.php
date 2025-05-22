@extends('auth.layout')

@section('title', 'Entrar')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" required autofocus class="form-control">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" name="password" type="password" required class="form-control">
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label for="remember" class="form-check-label">Lembrar-me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Entrar</button>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('register') }}" class="btn btn-secondary w-100">Criar Conta</a>
</div>
@endsection

@section('links')
    <a href="{{ route('password.request') }}" class="link-primary">Esqueceu a senha?</a>
@endsection
