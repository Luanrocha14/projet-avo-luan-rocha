@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 shadow">
    <div class="card-header">
        <h5><i class="bi bi-pencil-square me-1"></i> Editar Produto</h5>
    </div>

    <div class="card-body">
        <x-alert />

        <form action="{{ route('produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="{{ $produto->nome }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Imagem</label>
                <input type="file" name="imagem" class="form-control">
                @if ($produto->imagem)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Preço de Custo (R$)</label>
                <input type="number" step="0.01" name="preco_custo" class="form-control" value="{{ $produto->preco_custo }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Preço de Venda (R$)</label>
                <input type="number" step="0.01" name="preco_venda" class="form-control" value="{{ $produto->preco_venda }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3">{{ $produto->descricao }}</textarea>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check2-circle me-1"></i> Salvar Alterações
                </button>
                <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
