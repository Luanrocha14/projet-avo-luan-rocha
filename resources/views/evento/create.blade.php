@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center my-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Cadastro no Evento</h2>
            <p class="text-muted m-0">Informe seus dados para participar do evento.</p>
        </div>
        <a href="{{ route('evento.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            {{-- Mensagens globais --}}
            <x-alert />

            <form action="{{ route('evento.store') }}" method="POST" novalidate>
                @csrf

                <div class="row g-4">
                    {{-- Nome --}}
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input 
                                type="text"
                                name="nome"
                                class="form-control @error('nome') is-invalid @enderror"
                                id="nome"
                                placeholder="Nome completo"
                                value="{{ old('nome') }}"
                                required
                            >
                            <label for="nome">Nome completo</label>

                            @error('nome')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- CPF --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input 
                                type="text"
                                name="cpf"
                                class="form-control @error('cpf') is-invalid @enderror"
                                id="cpf"
                                placeholder="CPF"
                                value="{{ old('cpf') }}"
                                required
                            >
                            <label for="cpf">CPF</label>

                            @error('cpf')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <small class="text-muted">Somente números</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
