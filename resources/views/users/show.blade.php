@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border-light shadow">

    <div class="card-header hstack gap-2">
        <span>Visualizar Usuário</span>

        <span class="ms-auto d-sm-flex flex-row">

            <a href="{{ route('user.index') }}" class="btn btn-info btn-sm me-1">Listar</a>
            <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-warning btn-sm me-1">Editar</a>

            {{-- Botão que abre o modal --}}
            <button type="button" 
                class="btn btn-danger btn-sm me-1"
                data-bs-toggle="modal"
                data-bs-target="#deleteModal"
                data-bs-action="{{ route('user.destroy', ['user' => $user->id]) }}">
                Apagar
            </button>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $user->id }}</dd>

            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $user->name }}</dd>

            <dt class="col-sm-3">E-mail</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>

            <dt class="col-sm-3">Cadastrado</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</dd>

            <dt class="col-sm-3">Editado</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}</dd>
        </dl>
    </div>
</div>

{{-- Modal de confirmação de exclusão --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirmar exclusão</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja <strong>apagar este usuário</strong>? Essa ação não pode ser desfeita.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Apagar</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Script para atualizar a ação do form no modal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-bs-action');
        document.getElementById('deleteForm').setAttribute('action', action);
    });
});
</script>
@endsection
