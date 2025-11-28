@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="fw-bold text-secondary">Novo Lembrete</h2>
        <a href="{{ route('lembretes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Voltar para Lista
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            <x-alert />

            <form action="{{ route('lembretes.store') }}" method="POST">
                @csrf
                
                <h5 class="card-title mb-4 text-muted border-bottom pb-2">Informações da Conta</h5>

                <div class="row g-4">
                    {{-- Título --}}
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" name="titulo" class="form-control" id="floatingTitulo" placeholder="Ex: Conta de Luz" required>
                            <label for="floatingTitulo">Título do Lembrete</label>
                        </div>
                    </div>

                    {{-- Valor --}}
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">R$</span>
                            <div class="form-floating flex-grow-1">
                                <input type="number" name="valor" class="form-control border-start-0" id="floatingValor" step="0.01" placeholder="0,00" required>
                                <label for="floatingValor">Valor</label>
                            </div>
                        </div>
                    </div>

                    {{-- Data --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="data_vencimento" class="form-control" id="floatingDate" required>
                            <label for="floatingDate">Data de Vencimento</label>
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea name="descricao" class="form-control" placeholder="Detalhes" id="floatingDesc" style="height: 100px"></textarea>
                            <label for="floatingDesc">Descrição (Opcional)</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5">
                    <button type="reset" class="btn btn-light text-muted px-4 rounded-3">Limpar</button>
                    <button type="submit" class="btn btn-primary px-5 rounded-3 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Salvar Lembrete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection