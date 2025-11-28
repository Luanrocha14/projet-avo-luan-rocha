@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="fw-bold text-secondary">Editar Lembrete</h2>
        <a href="{{ route('lembretes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Cancelar
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            <x-alert />

            <form action="{{ route('lembretes.update', $lembrete->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- Título --}}
                    <div class="col-md-8">
                        <div class="form-floating">
                            <input type="text" name="titulo" class="form-control" id="floatingTitulo" 
                                   value="{{ old('titulo', $lembrete->titulo) }}" placeholder="Título" required>
                            <label for="floatingTitulo">Título</label>
                        </div>
                    </div>

                    {{-- Status Pago (Select Moderno) --}}
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="pago" class="form-select" id="floatingSelect">
                                <option value="0" {{ old('pago', $lembrete->pago) ? '' : 'selected' }}>Pendente</option>
                                <option value="1" {{ old('pago', $lembrete->pago) ? 'selected' : '' }}>Pago</option>
                            </select>
                            <label for="floatingSelect">Status do Pagamento</label>
                        </div>
                    </div>

                    {{-- Valor --}}
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">R$</span>
                            <div class="form-floating flex-grow-1">
                                <input type="number" name="valor" class="form-control border-start-0" step="0.01" 
                                       value="{{ old('valor', $lembrete->valor) }}" id="floatingValor" required>
                                <label for="floatingValor">Valor</label>
                            </div>
                        </div>
                    </div>

                    {{-- Data --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="data_vencimento" class="form-control" id="floatingDate"
                                   value="{{ old('data_vencimento', \Carbon\Carbon::parse($lembrete->data_vencimento)->format('Y-m-d')) }}" required>
                            <label for="floatingDate">Data de Vencimento</label>
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea name="descricao" class="form-control" placeholder="Detalhes" id="floatingDesc" style="height: 120px">{{ old('descricao', $lembrete->descricao) }}</textarea>
                            <label for="floatingDesc">Descrição</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    {{-- Botão Excluir (Esquerda) --}}
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#modalDeleteEdit">
                        <i class="bi bi-trash me-1"></i> Excluir Registro
                    </button>

                    {{-- Botões de Ação (Direita) --}}
                    <button type="submit" class="btn btn-success btn-lg px-5 rounded-3 fw-bold text-white">
                        <i class="bi bi-check-circle me-1"></i> Atualizar Dados
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal de Exclusão separado para não conflitar com o form principal --}}
<div class="modal fade" id="modalDeleteEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <i class="bi bi-exclamation-triangle-fill text-danger display-4 mb-3"></i>
                <h4 class="mb-3">Tem certeza?</h4>
                <p class="text-muted mb-4">Você está prestes a excluir o lembrete <strong>{{ $lembrete->titulo }}</strong>. Esta ação é irreversível.</p>
                
                <form action="{{ route('lembretes.destroy', $lembrete->id) }}" method="POST" class="d-flex justify-content-center gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger px-4">Sim, excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection