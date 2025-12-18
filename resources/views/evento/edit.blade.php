@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Editar Inscrição</h2>

    <form action="{{ route('evento.update', $inscrito->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Indica que estamos fazendo uma atualização -->

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $inscrito->nome) }}" required>
        </div>

        <div class="mb-3">
            <label>CPF</label>
            <input type="text" name="cpf" class="form-control" value="{{ old('cpf', $inscrito->cpf) }}" required>
        </div>

        <button class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
