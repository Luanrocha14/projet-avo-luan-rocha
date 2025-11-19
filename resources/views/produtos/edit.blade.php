@extends('layouts.admin')

@section('content')
<div class="card mt-4 border-light shadow">
    <div class="card-header bg-light">
        <h5 class="mb-0">Editar Produto</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nome --}}
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="{{ $produto->nome }}" required>
            </div>

            {{-- Descricao --}}
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control">{{ $produto->descricao }}</textarea>
            </div>

            {{-- Preços --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Preço de Custo</label>
                    <input type="number" name="preco_custo" step="0.01" class="form-control"
                           value="{{ $produto->preco_custo }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Preço de Venda</label>
                    <input type="number" name="preco_venda" step="0.01" class="form-control"
                           value="{{ $produto->preco_venda }}" required>
                </div>
            </div>

            <hr>

            {{-- IMAGENS EXISTENTES --}}
            <h5 class="mb-3">Imagens atuais</h5>

            <div class="row">
                @foreach ($produto->imagens as $img)
                <div class="col-md-3 mb-4 text-center">

                    {{-- Imagem --}}
                    <img src="{{ asset('storage/' . $img->caminho) }}"
                         class="img-fluid rounded mb-2"
                         style="height:120px; width:100%; object-fit:cover;">

                    {{-- Remover imagem --}}
                    <div class="form-check">
                        <input type="checkbox"
                               name="apagar_imagens[]"
                               value="{{ $img->id }}"
                               class="form-check-input">
                        <label class="form-check-label">Remover</label>
                    </div>

                    {{-- Marcar como carrossel --}}
                    <div class="form-check mt-1">
                        <input type="checkbox"
                               name="carousel_imagens[]"
                               value="{{ $img->id }}"
                               class="form-check-input"
                               @checked($img->carousel)>
                        <label class="form-check-label">Carrossel</label>
                    </div>

                </div>
                @endforeach
            </div>

            <hr>

            {{-- NOVAS IMAGENS --}}
            <div class="mb-3">
                <label class="form-label">Adicionar novas imagens</label>
                <input type="file" name="imagens[]" multiple class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">
                Salvar Alterações
            </button>
        </form>
    </div>
</div>
@endsection
