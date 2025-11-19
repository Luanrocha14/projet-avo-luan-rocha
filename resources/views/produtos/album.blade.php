@extends('layouts.admin')

@section('content')

<div class="card mt-4 mb-4 shadow border-0">

    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-grid-fill me-2"></i> Álbum de Produtos
        </h4>
    </div>

    <div class="card-body">

        <x-alert />

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

            @foreach ($produtos as $produto)
                <div class="col">
                    <div class="card shadow-sm border-0 h-100 rounded-3 product-card">

                        {{-- MULTIPLAS IMAGENS → CARROSSEL SIMPLES (SEM BOTÕES) --}}
                        @if ($produto->imagens->count() > 1)

                            <div id="carousel-produto-{{ $produto->id }}"
                                 class="carousel slide rounded-top"
                                 data-bs-ride="carousel">

                                <div class="carousel-inner">

                                    @foreach ($produto->imagens as $index => $img)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $img->caminho) }}"
                                                 class="d-block w-100 rounded-top"
                                                 style="height: 250px; object-fit: cover;">
                                        </div>
                                    @endforeach

                                </div>

                            </div>

                        {{-- UMA IMAGEM --}}
                        @elseif ($produto->imagens->count() == 1)

                            <img src="{{ asset('storage/' . $produto->imagens->first()->caminho) }}"
                                 class="card-img-top rounded-top"
                                 style="height: 250px; object-fit: cover;">

                        {{-- SEM IMAGENS --}}
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-top"
                                 style="height: 250px;">
                                <span class="text-muted">Sem imagem</span>
                            </div>
                        @endif


                        {{-- INFORMAÇÕES DO PRODUTO --}}
                        <div class="card-body d-flex flex-column">

                            <h5 class="fw-bold mb-1">{{ $produto->nome }}</h5>

                            <p class="text-muted mb-3" style="font-size: .9rem;">
                                {{ Str::limit($produto->descricao, 80) }}
                            </p>

                            <div class="mt-auto">

                                <hr>

                                @php
                                    $custo = $produto->preco_custo;
                                    $venda = $produto->preco_venda;
                                    $desconto = $venda < $custo ? 0 : (($venda - $custo) / $custo) * 100;
                                    $lucro = $venda - $custo;
                                @endphp

                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="fw-bold text-success fs-5">
                                        R$ {{ number_format($venda, 2, ',', '.') }}
                                    </span>

                                    <span class="text-muted text-decoration-line-through">
                                        R$ {{ number_format($custo, 2, ',', '.') }}
                                    </span>

                                    <span class="badge bg-primary px-2 py-1">
                                        {{ number_format($desconto, 0) }}% OFF
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">

                                    <a href="{{ route('produtos.show', $produto->id) }}"
                                       class="btn btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>

                                    <span class="fw-bold {{ $lucro >= 0 ? 'text-success' : 'text-danger' }}">
                                        R$ {{ number_format($lucro, 2, ',', '.') }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        <div class="mt-4">
            {{ $produtos->links() }}
        </div>

    </div>
</div>

<style>
.product-card {
    transition: .2s ease-in-out;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}
</style>

@endsection
