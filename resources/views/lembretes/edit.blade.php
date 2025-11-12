@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border-light shadow">
    <div class="card-header hstack gap-2">
        <span><i class="bi bi-pencil-square me-1"></i> Editar Lembrete</span>
        <span class="ms-auto">
            <a href="{{ route('lembretes.index') }}" class="btn btn-info btn-sm">
                <i class="bi bi-list-ul me-1"></i> Listar
            </a>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        <form action="{{ route('lembretes.update', $lembrete->id) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $lembrete->titulo) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Valor (R$)</label>
                <input type="number" name="valor" class="form-control" step="0.01" value="{{ old('valor', $lembrete->valor) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Data de Vencimento</label>
                <input type="date" name="data_vencimento" class="form-control" 
                       value="{{ old('data_vencimento', \Carbon\Carbon::parse($lembrete->data_vencimento)->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3">{{ old('descricao', $lembrete->descricao) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Pago?</label>
                <select name="pago" class="form-select">
                    <option value="0" {{ old('pago', $lembrete->pago) ? '' : 'selected' }}>Não</option>
                    <option value="1" {{ old('pago', $lembrete->pago) ? 'selected' : '' }}>Sim</option>
                </select>
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-check-circle me-1"></i> Atualizar
                </button>

                <a href="{{ route('lembretes.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </a>

                {{-- Botão de excluir (opcional) --}}
                <form action="{{ route('lembretes.destroy', $lembrete->id) }}" method="POST" class="ms-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente apagar este lembrete?')">
                        <i class="bi bi-trash me-1"></i> Excluir
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection
