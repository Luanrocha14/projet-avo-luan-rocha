@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border-light shadow">
    <div class="card-header hstack gap-2">
        <span><i class="bi bi-plus-circle me-1"></i> Novo Lembrete</span>
        <span class="ms-auto">
            <a href="{{ route('lembretes.index') }}" class="btn btn-info btn-sm">
                <i class="bi bi-list-ul me-1"></i> Listar
            </a>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        <form action="{{ route('lembretes.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Valor (R$)</label>
                <input type="number" name="valor" class="form-control" step="0.01" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Data de Vencimento</label>
                <input type="date" name="data_vencimento" class="form-control" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-check-circle me-1"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
