@extends('layouts.admin')

@section('content')
<div class="card mt-4 border-light shadow">
    <div class="card-header bg-light d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><i class="bi bi-box-seam me-1"></i> Listar Produtos</h5>
        <a href="{{ route('produtos.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Novo Produto
        </a>
    </div>

    <div class="card-body">
        <x-alert />

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço de Custo</th>
                    <th>Preço de Venda</th>
                    <th>Lucro</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produtos as $produto)
                    <tr>
                        <td style="width: 80px;">
                            @if ($produto->imagem)
                                <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <span class="text-muted">Sem imagem</span>
                            @endif
                        </td>
                        <td>{{ $produto->nome }}</td>
                        <td>R$ {{ number_format($produto->preco_custo, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</td>
                        <td>
                            @php
                                $lucro = $produto->preco_venda - $produto->preco_custo;
                                $cor = $lucro >= 0 ? 'success' : 'danger';
                            @endphp
                            <span class="badge bg-{{ $cor }}">
                                R$ {{ number_format($lucro, 2, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{-- ✏️ Editar --}}
                            <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- 🗑️ Excluir --}}
                            <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhum produto cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginação --}}
        {{ $produtos->links() }}
    </div>
</div>
@endsection
