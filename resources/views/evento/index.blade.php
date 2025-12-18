@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="fw-bold text-dark">Lista de Inscritos</h2>
        <a href="{{ route('evento.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Novo Cadastro
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Nome</th>
                        <th>CPF</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscritos as $pessoa)
                        <tr>
                            <td class="px-4">{{ $pessoa->nome }}</td>
                            <td>{{ $pessoa->cpf }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">
                                Nenhum inscrito encontrado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINAÇÃO (AGORA FUNCIONA) --}}
        @if($inscritos->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $inscritos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
