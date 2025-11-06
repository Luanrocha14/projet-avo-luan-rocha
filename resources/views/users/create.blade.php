<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Celke</title>
</head>
<body>

    <a href="{{ route('user.index') }}">Lista</a><br>

    <h2>Cadastrar Usuário</h2>

    {{-- Mensagem de sucesso --}}
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Exibe todos os erros de validação --}}
    @if ($errors->any())
        <p style="color: #f00;">
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </p>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <label>Nome</label>
        <input type="text" name="name" placeholder="Nome completo" value="{{ old('name') }}"><br>
        @error('name')
            <small style="color: red;">{{ $message }}</small><br>
        @enderror
        <br>

        <label>E-mail:</label>
        <input type="email" name="email" placeholder="Melhor e-mail do Usuário" value="{{ old('email') }}"><br>
        @error('email')
            <small style="color: red;">{{ $message }}</small><br>
        @enderror
        <br>

        <label>Senha</label>
        <input type="password" name="password" placeholder="Senha com no mínimo 6 caracteres"><br>
        @error('password')
            <small style="color: red;">{{ $message }}</small><br>
        @enderror
        <br>

        <button type="submit">Cadastrar</button>
    </form>

</body>
</html>
