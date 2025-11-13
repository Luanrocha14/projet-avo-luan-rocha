@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 shadow">
    <div class="card-header">
        <h5><i class="bi bi-box-seam me-1"></i> Adicionar Produto</h5>
    </div>
    <div class="card-body">
        <x-alert />

        <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf

            <div class="col-md-6">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Imagem</label>
                <input type="file" name="imagem" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Preço de Custo (R$)</label>
                <input type="number" step="0.01" name="preco_custo" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Preço de Venda (R$)</label>
                <input type="number" step="0.01" name="preco_venda" class="form-control" required>
            </div>

            <div class="col-12">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check2-circle me-1"></i> Salvar Produto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
