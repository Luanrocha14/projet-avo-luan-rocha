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
                                <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                     alt="{{ $produto->nome }}" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
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
                            <a href="{{ route('produtos.edit', $produto->id) }}" 
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- 🗑️ Excluir (abre modal) --}}
                            <button type="button" 
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalExcluirProduto{{ $produto->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- 🗑️ Modal de Exclusão --}}
                    <div class="modal fade" id="modalExcluirProduto{{ $produto->id }}" 
                         tabindex="-1" 
                         aria-labelledby="modalExcluirProdutoLabel{{ $produto->id }}" 
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="modalExcluirProdutoLabel{{ $produto->id }}">
                                        <i class="bi bi-trash3 me-1"></i> Confirmar Exclusão
                                    </h5>
                                    <button type="button" 
                                            class="btn-close btn-close-white" 
                                            data-bs-dismiss="modal" 
                                            aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza que deseja excluir o produto <strong>{{ $produto->nome }}</strong>?</p>
                                    <p>Esta ação <strong>não pode ser desfeita</strong>.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" 
                                            class="btn btn-secondary" 
                                            data-bs-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <form action="{{ route('produtos.destroy', $produto->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger">
                                            <i class="bi bi-trash3-fill me-1"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
