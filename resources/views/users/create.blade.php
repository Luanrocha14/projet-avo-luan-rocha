@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span><i class="bi bi-person-plus me-1"></i> Cadastrar Usuário</span>

            <span class="ms-auto d-sm-flex flex-row">
                <a href="{{ route('user.index') }}" class="btn btn-info btn-sm me-1">
                    <i class="bi bi-list-ul me-1"></i> Listar
                </a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <form action="{{ route('user.store') }}" method="POST" class="row g-3">
                @csrf
                @method('POST')

                <div class="col-md-12">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nome completo"
                        value="{{ old('name') }}">
                </div>

                <div class="col-md-12">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="Melhor e-mail do usuário" value="{{ old('email') }}">
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
                        <input type="password" name="password_confirmation" class="form-control"
                            id="password_confirmation" placeholder="Confirme a senha"
                            value="{{ old('password_confirmation') }}">
                        <span class="input-group-text" role="button"
                            onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle me-1"></i> Cadastrar
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Script para mostrar/ocultar senha --}}
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
