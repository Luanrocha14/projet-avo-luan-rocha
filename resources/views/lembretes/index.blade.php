@extends('layouts.admin')

@section('content')

@php
    use Carbon\Carbon;
    use App\Models\Lembrete;

    $totalPendentes = Lembrete::where('pago', false)->count();
    $pagos = Lembrete::where('pago', true)->get();

    // Estatísticas
    $pagosEmDia = $pagos->filter(fn($l) => Carbon::parse($l->data_pagamento)->lte(Carbon::parse($l->data_vencimento)))->count();
    $pagosAtraso = $pagos->filter(fn($l) => Carbon::parse($l->data_pagamento)->gt(Carbon::parse($l->data_vencimento)))->count();

    // Valor pendente
    $valorPendente = Lembrete::where('pago', false)->sum('valor');
@endphp

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Dashboard Financeiro</h2>
            <p class="text-muted m-0">Visão geral das suas contas e lembretes.</p>
        </div>
        <a href="{{ route('lembretes.create') }}" class="btn btn-primary rounded-3 px-4 py-2 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Novo Lembrete
        </a>
    </div>

    {{-- Painel Estatísticas --}}
    <div class="row g-4 mb-5">
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-danger">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase text-muted small fw-bold mb-1">Pendentes</h6>
                        <h2 class="fw-bold text-danger m-0">{{ $totalPendentes }}</h2>
                        <small class="text-muted">R$ {{ number_format($valorPendente, 2, ',', '.') }} em aberto</small>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-exclamation-diamond text-danger fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-success">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase text-muted small fw-bold mb-1">Pagos em Dia</h6>
                        <h2 class="fw-bold text-success m-0">{{ $pagosEmDia }}</h2>
                        <small class="text-muted">Parabéns pela pontualidade!</small>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-shield-check text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-warning">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase text-muted small fw-bold mb-1">Pagos com Atraso</h6>
                        <h2 class="fw-bold text-warning m-0">{{ $pagosAtraso }}</h2>
                        <small class="text-muted">Atenção aos prazos</small>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-hourglass-split text-warning fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabela de Pendentes --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-header bg-white border-0 py-3 px-4 rounded-top-4 d-flex align-items-center">
            <h5 class="m-0 fw-bold text-secondary"><i class="bi bi-wallet2 me-2"></i>Contas a Pagar</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary small text-uppercase">Título</th>
                        <th class="py-3 text-secondary small text-uppercase">Valor</th>
                        <th class="py-3 text-secondary small text-uppercase">Vencimento</th>
                        <th class="py-3 text-secondary small text-uppercase">Status</th>
                        <th class="px-4 py-3 text-end text-secondary small text-uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @php $pendentes = $lembretes->where('pago', false); @endphp

                    @forelse ($pendentes as $lembrete)
                        @php 
                            $vencimento = Carbon::parse($lembrete->data_vencimento);
                            $hoje = Carbon::now();
                            $atrasado = $hoje->gt($vencimento);
                        @endphp

                        <tr>
                            <td class="px-4 fw-bold text-dark">{{ $lembrete->titulo }}</td>
                            <td class="fw-bold text-secondary">R$ {{ number_format($lembrete->valor, 2, ',', '.') }}</td>
                            <td>
                                <span class="{{ $atrasado ? 'text-danger fw-bold' : 'text-dark' }}">
                                    {{ $vencimento->format('d/m/Y') }}
                                    @if($atrasado)
                                        <i class="bi bi-exclamation-circle-fill ms-1"></i>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                    Pendente
                                </span>
                            </td>

                            <td class="px-4 text-end">
                                <a class="btn btn-sm btn-light text-success border-0 shadow-sm me-1"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modalPagar{{ $lembrete->id }}">
                                    <i class="bi bi-cash-coin"></i>
                                </a>

                                <a href="{{ route('lembretes.edit', $lembrete->id) }}" 
                                   class="btn btn-sm btn-light text-primary border-0 shadow-sm me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                <a class="btn btn-sm btn-light text-danger border-0 shadow-sm"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modalExcluir{{ $lembrete->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>

                        @include('lembretes.partials.modals', ['lembrete' => $lembrete])

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-smile display-4 d-block mb-3 opacity-25"></i>
                                Nenhuma conta pendente!
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        @if($pendentes->isNotEmpty())
            <div class="card-footer bg-white border-0 py-3">
                {{ $lembretes->links() }}
            </div>
        @endif
    </div>

    {{-- Histórico Rápido --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4 rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="m-0 fw-bold text-secondary">
                <i class="bi bi-clock-history me-2"></i>Últimos Pagamentos
            </h5>

            <a href="{{ route('lembretes.historico') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                Ver Tudo
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped align-middle mb-0 opacity-75">
                <tbody>
                    @foreach ($pagos->take(6) as $pago)
                        <tr>
                            <td class="px-4">{{ $pago->titulo }}</td>
                            <td>R$ {{ number_format($pago->valor, 2, ',', '.') }}</td>
                            <td class="text-end px-4 text-muted small">
                                Pago em {{ \Carbon\Carbon::parse($pago->data_pagamento)->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
