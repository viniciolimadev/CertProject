@extends('layout')

@section('title', 'Minhas Experiências')

@section('content')
<div class="container">
    <h1>Experiências Profissionais</h1>

    <a href="{{ route('experiences.create') }}" class="btn btn-primary mb-3">Adicionar Experiência</a>

    @foreach ($experiences as $exp)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $exp->position }} — <strong>{{ $exp->company }}</strong></h5>
                <p>{{ $exp->description }}</p>
                <p><small>
                    {{ \Carbon\Carbon::parse($exp->start_date)->format('m/Y') }}
                    –
                    {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('m/Y') : 'Atual' }}
                </small></p>

                <form action="{{ route('experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Deseja deletar esta experiência?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Deletar</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
