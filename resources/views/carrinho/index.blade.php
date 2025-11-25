@extends('layouts.admin')

@section('title', 'Carrinho de Compras')

@section('content')

<div class="container mt-4 cart-container">

    <h1 class="cart-title mb-4">🛒 Meu Carrinho</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(empty($carrinho))
        <p>Seu carrinho está vazio.</p>

        <a href="{{ url('/produtos') }}" class="btn btn-primary mt-3">
            🔙 Voltar para loja
        </a>

    @else

        <table class="table table-bordered cart-table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Qtd</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                @php $totalGeral = 0; @endphp

                @foreach($carrinho as $item)

                    @php
                        // 1) Se o carrinho já tem imagem
                        if ($item['imagem']) {
                            $imgUrl = asset('storage/' . $item['imagem']);
                        } else {
                            // 2) Buscar no banco a primeira imagem desse produto
                            $imgDB = \App\Models\ProdutoImagem::where('produto_id', $item['id'])->first();

                            if ($imgDB) {
                                $imgUrl = asset('storage/' . $imgDB->caminho);
                            } else {
                                // 3) Sem imagem → placeholder
                                $imgUrl = asset('images/sem-imagem.png');
                            }
                        }

                        $total = $item['preco'] * $item['quantidade'];
                        $totalGeral += $total;
                    @endphp

                    <tr>
                        <td>
                            <img src="{{ $imgUrl }}"
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                        </td>

                        <td>{{ $item['nome'] }}</td>

                        <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>

                        <td>{{ $item['quantidade'] }}</td>

                        <td>R$ {{ number_format($total, 2, ',', '.') }}</td>

                        <td>
                            <a href="{{ route('carrinho.remover', $item['id']) }}"
                                class="btn btn-danger btn-sm btn-remove">
                                Remover
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="total-box mt-3">
            Total geral: <strong>R$ {{ number_format($totalGeral, 2, ',', '.') }}</strong>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ url('/produtos') }}" class="btn btn-secondary">
                Continuar Comprando
            </a>

            <a href="#" class="btn btn-success">
                Finalizar Compra
            </a>
        </div>

    @endif
</div>

@endsection
