@extends('layouts.main')

@section('title', 'Meu Carrinho')

@section('content')

<div class="container mt-4">
    <h1>Meu Carrinho</h1>

    @if (count($carrinho) == 0)
        <p>Seu carrinho está vazio.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carrinho as $item)
                <tr>
                    <td><img src="/storage/{{ $item['imagem'] }}" width="70"></td>
                    <td>{{ $item['nome'] }}</td>
                    <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                    <td>{{ $item['quantidade'] }}</td>
                    <td>R$ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('carrinho.remover', $item['id']) }}" class="btn btn-danger btn-sm">
                            Remover
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
