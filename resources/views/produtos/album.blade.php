@extends('layouts.admin')

@section('content')
<div class="card mb-4 border-light shadow">
    <div class="card mt-4 header hstack gap-2">
        <span><i class="bi bi-grid me-1"></i> Catálogo de Produtos</span>
        <span class="ms-auto">
            <a href="{{ route('produtos.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Novo Produto
            </a>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @foreach ($produtos as $produto)
                <div class="col">
                    <div class="card shadow-sm h-100">
                        {{-- 📸 Imagem do produto --}}
                        @if ($produto->imagem)
                            <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                 class="card-img-top" 
                                 style="object-fit: cover; height: 200px;" 
                                 alt="{{ $produto->nome }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <span class="text-muted">Sem imagem</span>
                            </div>
                        @endif

                        {{-- 🧾 Conteúdo --}}
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title mb-2">{{ $produto->nome }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($produto->descricao, 80) }}</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="btn-group">
                                    {{-- 🔍 Ver --}}
                                    <a href="{{ route('produtos.show', $produto->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>

                                    {{-- ✏️ Editar --}}
                                    <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                </div>

                                {{-- 💰 Exibe lucro com cor dinâmica --}}
                                @php
                                    $lucro = $produto->preco_venda - $produto->preco_custo;
                                    $cor = $lucro >= 0 ? 'text-success' : 'text-danger';
                                @endphp
                                <small class="fw-bold {{ $cor }}">
                                    Lucro: R$ {{ number_format($lucro, 2, ',', '.') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginação --}}
        <div class="mt-4">
            {{ $produtos->links() }}
        </div>
    </div>
</div>
@endsection
