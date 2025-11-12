@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border-light shadow">
    <div class="card-header hstack gap-2">
        <span><i class="bi bi-pencil-square me-1"></i> Editar Usuário</span>

        <span class="ms-auto d-sm-flex flex-row">
            <a href="{{ route('user.index') }}" class="btn btn-info btn-sm me-1">
                <i class="bi bi-list-ul me-1"></i> Listar
            </a>

            <a href="{{ route('user.show', ['user' => $user->id]) }}" class="btn btn-primary btn-sm me-1">
                <i class="bi bi-eye me-1"></i> Visualizar
            </a>
        </span>
    </div>

    <div class="card-body">
        <x-alert />

        {{-- Formulário principal --}}
        <form id="formEditUser" action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-12">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" id="name"
                       placeholder="Nome completo" value="{{ old('name', $user->name) }}">
            </div>

            <div class="col-md-12">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" id="email"
                       placeholder="Melhor e-mail do usuário" value="{{ old('email', $user->email) }}">
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="Senha com no mínimo 6 caracteres" value="{{ old('password') }}">
                    <span class="input-group-text" role="button" onclick="togglePassword('password', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                           placeholder="Confirme a senha" value="{{ old('password_confirmation') }}">
                    <span class="input-group-text" role="button" onclick="togglePassword('password_confirmation', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <div class="col-12 d-flex gap-2">
                {{-- Botão que abre a modal --}}
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalConfirmarEdicao">
                    <i class="bi bi-save me-1"></i> Salvar
                </button>

                <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

{{-- 💬 Modal de Confirmação --}}
<div class="modal fade" id="modalConfirmarEdicao" tabindex="-1" aria-labelledby="modalLabelConfirmarEdicao" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalLabelConfirmarEdicao">
                    <i class="bi bi-question-circle me-1"></i> Confirmar Alterações
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja <strong>salvar as alterações</strong> deste usuário?</p>
                <p class="text-muted mb-0">As mudanças serão aplicadas imediatamente após confirmar.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning" onclick="document.getElementById('formEditUser').submit()">
                    <i class="bi bi-check2-circle me-1"></i> Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 🔒 Script para mostrar/ocultar senha --}}
<script>
    function togglePassword(id, el) {
        const input = document.getElementById(id);
        const icon = el.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endsection
