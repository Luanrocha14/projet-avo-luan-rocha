@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border-light shadow">
    <div class="card-header hstack gap-2">
        <span><i class="bi bi-check2-circle me-1"></i> Histórico de Contas Pagas</span>

        <span class="ms-auto">
            <a href="{{ route('lembretes.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Valor</th>
                    <th>Data de Vencimento</th>
                    <th>Data de Pagamento</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pagos as $pago)
                    <tr>
                        <td>{{ $pago->titulo }}</td>
                        <td>R$ {{ number_format($pago->valor, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pago->data_vencimento)->format('d/m/Y') }}</td>
                        <td>{{ $pago->data_pagamento ? \Carbon\Carbon::parse($pago->data_pagamento)->format('d/m/Y') : '-' }}</td>
                        <td class="text-center">
                            {{-- 🗑️ Botão de deletar --}}
                            <form action="{{ route('lembretes.destroy', $pago->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja realmente excluir este registro pago?')">
                                    <i class="bi bi-trash me-1"></i> Apagar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Nenhuma conta paga encontrada.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginação --}}
        {{ $pagos->links() }}
    </div>
</div>
@endsection
