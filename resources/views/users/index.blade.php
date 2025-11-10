@extends('layouts.admin')

@section('content')
<div class="card mb-4 border-light shadow">

    <div class="card mt-4 header hstack gap-2">
        <span>Listar Usuários</span>

        <span class="ms-auto">
            <a href="{{ route('user.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar
            </a>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            {{-- Botão que abre o modal de visualização --}}
                            <button type="button" 
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#viewUserModal"
                                data-user='@json($user)'>
                                <i class="bi bi-eye"></i>
                            </button>

                            {{-- Botão de edição --}}
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- Botão que abre o modal de confirmação de exclusão --}}
                            <button type="button"
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal"
                                data-user-id="{{ $user->id }}"
                                data-user-name="{{ $user->name }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</div>

{{-- Modal de visualização do usuário --}}
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-petroleo text-white">
        <h5 class="modal-title" id="viewUserModalLabel">Detalhes do Usuário</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">ID:</dt>
            <dd class="col-sm-9" id="userId"></dd>

            <dt class="col-sm-3">Nome:</dt>
            <dd class="col-sm-9" id="userName"></dd>

            <dt class="col-sm-3">E-mail:</dt>
            <dd class="col-sm-9" id="userEmail"></dd>

            <dt class="col-sm-3">Criado em:</dt>
            <dd class="col-sm-9" id="userCreated"></dd>

            <dt class="col-sm-3">Atualizado:</dt>
            <dd class="col-sm-9" id="userUpdated"></dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal de confirmação de exclusão --}}
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteUserModalLabel">Confirmar Exclusão</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p>Tem certeza que deseja apagar o usuário <strong id="deleteUserName"></strong>?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteUserForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Apagar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Script que controla os modais --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Modal de visualização
    const viewModal = document.getElementById('viewUserModal');
    viewModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const user = JSON.parse(button.getAttribute('data-user'));
        document.getElementById('userId').textContent = user.id;
        document.getElementById('userName').textContent = user.name;
        document.getElementById('userEmail').textContent = user.email;
        document.getElementById('userCreated').textContent = new Date(user.created_at).toLocaleString('pt-BR');
        document.getElementById('userUpdated').textContent = new Date(user.updated_at).toLocaleString('pt-BR');
    });

    // Modal de exclusão
    const deleteModal = document.getElementById('deleteUserModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteUserForm').action = `/user/${userId}`;
    });
});
</script>
@endsection
