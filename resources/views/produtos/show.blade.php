@extends('layouts.admin')

@section('content')

<div class="card mt-4 mb-4 shadow border-0">

    {{-- Cabeçalho elegante --}}
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 py-3">
        <h4 class="mb-0 fw-bold">
            <i class="bi bi-eye me-2"></i> Visualizar Produto
        </h4>

        <a href="{{ route('produtos.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card-body">

        <div class="row g-4">

            {{-- 📸 Imagem grande --}}
            <div class="col-md-5">

                @php
                    $imagemPrincipal = $produto->imagens->first();
                @endphp

                @if ($imagemPrincipal)
                    <img src="{{ asset('storage/' . $imagemPrincipal->caminho) }}"
                        class="img-fluid rounded shadow-sm"
                        style="width: 100%; height: 350px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded shadow-sm"
                        style="height: 350px;">
                        <span class="text-muted">Sem imagem</span>
                    </div>
                @endif

            </div>

            {{-- 📄 Informações --}}
            <div class="col-md-7">

                <h2 class="fw-bold mb-2">{{ $produto->nome }}</h2>

                {{-- 💰 Informações de preço --}}
                <div class="mt-3 p-3 bg-light rounded border">

                    @php
                        $custo = $produto->preco_custo;
                        $venda = $produto->preco_venda;
                        $desconto = $venda < $custo ? 0 : (($venda - $custo) / $custo) * 100;
                        $lucro = $venda - $custo;
                    @endphp

                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-3 text-success fw-bold">
                            R$ {{ number_format($venda, 2, ',', '.') }}
                        </span>

                        <span class="text-muted text-decoration-line-through fs-6">
                            R$ {{ number_format($custo, 2, ',', '.') }}
                        </span>

                        <span class="badge bg-primary px-3 py-2">
                            {{ number_format($desconto, 0) }}% OFF
                        </span>
                    </div>

                    <p class="mt-3 mb-0 fw-semibold">
                        Lucro:
                        <span class="{{ $lucro >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            R$ {{ number_format($lucro, 2, ',', '.') }}
                        </span>
                    </p>
                </div>

                <hr class="my-4">

                {{-- 📝 Descrição --}}
                <h5 class="fw-bold">Descrição</h5>
                <p class="text-muted mb-4" style="white-space: pre-line;">
                    {{ $produto->descricao ?: 'Nenhuma descrição informada.' }}
                </p>

                <hr class="my-4">

                {{-- Botões --}}
                <div class="mt-4 d-flex gap-3">

                    <a href="{{ route('carrinho.adicionar', $produto->id) }}" 
                        class="btn btn-success px-4">
                        <i class="bi bi-cart-plus me-1"></i> Adicionar ao Carrinho
                    </a>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection
