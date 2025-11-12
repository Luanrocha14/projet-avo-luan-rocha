@extends('layouts.admin')

@section('content')
<div class="card mb-4 border-light shadow">
    <div class="card mt-4 header hstack gap-2">
        <span><i class="bi bi-wallet2 me-1"></i> Listar Lembretes de Dívidas</span>

        <span class="ms-auto">
            <a href="{{ route('lembretes.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Novo Lembrete
            </a>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        {{-- 🧾 Tabela de Lembretes PENDENTES --}}
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Valor</th>
                    <th>Data de Vencimento</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $pendentes = $lembretes->where('pago', false);
                @endphp

                @forelse ($pendentes as $lembrete)
                    <tr>
                        <td>{{ $lembrete->titulo }}</td>
                        <td>R$ {{ number_format($lembrete->valor, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($lembrete->data_vencimento)->format('d/m/Y') }}</td>
                        <td><span class="badge bg-danger">Pendente</span></td>

                        <td class="text-center">
                            {{-- 💰 Botão modal de pagamento --}}
                            <button type="button"
                                    class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalPagar{{ $lembrete->id }}">
                                <i class="bi bi-cash-coin me-1"></i> Pagar
                            </button>

                            {{-- ✏️ Editar --}}
                            <a href="{{ route('lembretes.edit', $lembrete->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- 🗑️ Excluir --}}
                            <form action="{{ route('lembretes.destroy', $lembrete->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir este lembrete?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- 💳 Modal de pagamento --}}
                    <div class="modal fade" id="modalPagar{{ $lembrete->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $lembrete->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="modalLabel{{ $lembrete->id }}">
                                        <i class="bi bi-cash-stack me-1"></i> Confirmar Pagamento
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza que deseja marcar a conta <strong>{{ $lembrete->titulo }}</strong> como paga?</p>
                                    <p class="mb-0">Valor: <strong>R$ {{ number_format($lembrete->valor, 2, ',', '.') }}</strong></p>
                                    <p>Vencimento: <strong>{{ \Carbon\Carbon::parse($lembrete->data_vencimento)->format('d/m/Y') }}</strong></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('lembretes.pagar', $lembrete->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check2-circle me-1"></i> Confirmar Pagamento
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr><td colspan="5" class="text-center text-muted">Nenhum lembrete pendente encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $lembretes->links() }}
    </div>
</div>

{{-- 🕘 Histórico de contas pagas --}}
<div class="card mt-4 border-light shadow">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-clock-history me-1"></i> Histórico de Contas Pagas</h5>
    </div>

    <div class="card-body">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Valor</th>
                    <th>Data de Vencimento</th>
                    <th>Data de Pagamento</th>
                    <th>Status</th>
                    <th>Situação</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pagos = \App\Models\Lembrete::where('pago', true)
                                ->orderByDesc('data_pagamento')
                                ->get();
                @endphp

                @forelse ($pagos as $pago)
                    @php
                        $vencimento = \Carbon\Carbon::parse($pago->data_vencimento);
                        $pagamento = \Carbon\Carbon::parse($pago->data_pagamento);
                        $situacao = $pagamento->lte($vencimento) ? 'Pago em dia' : 'Paga com atraso';
                    @endphp
                    <tr>
                        <td>{{ $pago->titulo }}</td>
                        <td>R$ {{ number_format($pago->valor, 2, ',', '.') }}</td>
                        <td>{{ $vencimento->format('d/m/Y') }}</td>
                        <td>{{ $pagamento->format('d/m/Y') }}</td>
                        <td><span class="badge bg-success">Pago</span></td>
                        <td>
                            @if ($situacao === 'Pago em dia')
                                <span class="badge bg-primary">{{ $situacao }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $situacao }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('lembretes.destroy', $pago->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja remover este item do histórico?')">
                                    <i class="bi bi-trash"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Nenhuma conta paga ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
