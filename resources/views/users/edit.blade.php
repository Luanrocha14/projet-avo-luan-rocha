<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
</head>

<body>

    <a href="{{ route('user.index') }}">Lista</a><br>
    <a href="{{ route('user.show', ['user' => $user->id]) }}">Visualizar</a><br>

    <h2>Editar Usuário</h2>

    @if ($errors->any())
        <p style="color: #f00;">
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </p>
    @endif

    <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST"> {{-- ✅ corrigido --}}
        @csrf
        @method('PUT')

        <label>Nome</label>
        <input type="text" name="name" placeholder="Nome completo" value="{{ old('name', $user->name) }}"><br>
        @error('name')
            <small style="color: red;">{{ $message }}</small><br>
        @enderror
        <br>

        <label>E-mail:</label>
        <input type="email" name="email" placeholder="Melhor e-mail do Usuário" value="{{ old('email', $user->email) }}"><br>
        @error('email')
            <small style="color: red;">{{ $message }}</small><br>
        @enderror
        <br>

        <label>Senha (deixe em branco se não quiser alterar)</label>
        <input type="password" name="password" placeholder="Senha com no mínimo 6 caracteres"><br>
        @error('password')
            <small style="color: red;">{{ $message }}</small><br>
        @enderror
        <br>

        <button type="submit">Salvar</button>
    </form>

</body>
</html>
