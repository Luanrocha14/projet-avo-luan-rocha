@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Histórico de Pagamentos</h2>
            <p class="text-muted m-0">Registro completo de contas liquidadas.</p>
        </div>
        <a href="{{ route('lembretes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Voltar ao Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <x-alert />

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="px-4 py-3 text-secondary small text-uppercase">Título</th>
                            <th class="py-3 text-secondary small text-uppercase">Valor</th>
                            <th class="py-3 text-secondary small text-uppercase">Vencimento</th>
                            <th class="py-3 text-secondary small text-uppercase">Pagamento</th>
                            <th class="py-3 text-secondary small text-uppercase">Situação</th>
                            <th class="px-4 py-3 text-end text-secondary small text-uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pagos as $pago)
                            @php
                                $venc = \Carbon\Carbon::parse($pago->data_vencimento);
                                $pag = $pago->data_pagamento ? \Carbon\Carbon::parse($pago->data_pagamento) : null;
                                $emDia = $pag && $pag->lte($venc);
                            @endphp
                            <tr>
                                <td class="px-4 fw-medium">{{ $pago->titulo }}</td>
                                <td class="text-muted">R$ {{ number_format($pago->valor, 2, ',', '.') }}</td>
                                <td class="text-muted small">{{ $venc->format('d/m/Y') }}</td>
                                <td class="fw-bold text-dark">{{ $pag ? $pag->format('d/m/Y') : '-' }}</td>
                                
                                <td>
                                    @if($emDia)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                            <i class="bi bi-check-circle me-1"></i> Em Dia
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">
                                            <i class="bi bi-clock-history me-1"></i> Atrasado
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 text-end">
                                    <form action="{{ route('lembretes.destroy', $pago->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-muted border-0 hover-danger"
                                            onclick="return confirm('Deseja realmente apagar este registro do histórico?')" title="Apagar Registro">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-4 d-block mb-3 opacity-25"></i>
                                    Nenhum histórico encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($pagos->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                {{ $pagos->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Pequeno ajuste extra para hover no botão de deletar */
    .hover-danger:hover {
        color: #dc3545 !important;
        background-color: #fee2e2 !important;
    }
</style>
@endsection