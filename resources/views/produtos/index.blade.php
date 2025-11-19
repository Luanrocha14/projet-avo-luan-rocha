@extends('layouts.admin')

@section('content')

{{-- CARROSSEL DO PRODUTO --}}
@php
    $imagensCarousel = $produtos->pluck('imagens')->flatten()->where('carousel', true);
@endphp

@if ($imagensCarousel->count() > 0)
<div id="carouselExampleSlidesOnly" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">

        @php $primeira = true; @endphp

        @foreach ($imagensCarousel as $img)
            <div class="carousel-item @if($primeira) active @php $primeira = false; @endphp @endif">
                <img src="{{ asset('storage/' . $img->caminho) }}"
                     class="d-block w-100"
                     style="height: 300px; object-fit: cover;"
                     alt="Imagem do produto">
            </div>
        @endforeach

    </div>
</div>
@endif


<div class="card mt-4 border-light shadow">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Listar Produtos</h5>
        <a href="{{ route('produtos.create') }}" class="btn btn-success btn-sm">Novo Produto</a>
    </div>

    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Carrossel</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($produtos as $produto)
                <tr>
                    <td>
                        @if ($produto->imagem)
                            <img src="{{ asset('storage/' . $produto->imagem) }}" class="img-thumbnail"
                                 style="width:60px; height:60px; object-fit:cover;">
                        @else
                            <span class="text-muted">Sem imagem</span>
                        @endif
                    </td>

                    <td>{{ $produto->nome }}</td>

                    <td>
                        R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                    </td>

                    <td>
                        @if ($produto->imagens->where('carousel', true)->count() > 0)
                            <span class="badge bg-primary">Sim</span>
                        @else
                            <span class="badge bg-secondary">Não</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a class="btn btn-warning btn-sm"
                           href="{{ route('produtos.edit', $produto->id) }}">
                           Editar
                        </a>

                        <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalExcluir{{ $produto->id }}">
                            Excluir
                        </button>
                    </td>
                </tr>

                {{-- Modal de Exclusão --}}
                <div class="modal fade" id="modalExcluir{{ $produto->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('produtos.destroy', $produto->id) }}">
                                @csrf
                                @method('DELETE')

                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Confirmar exclusão</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    Tem certeza que deseja excluir <strong>{{ $produto->nome }}</strong>?
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>

                                    <button type="submit" class="btn btn-danger">
                                        Excluir
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>

        {{ $produtos->links() }}
    </div>
</div>
@endsection
