<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Celke</title>
</head>
<body>

    <a href="{{ route('user.create')}}">Cadastrar</a><br>

    <h2>Listar Usuários</h2>

    @if (session('success'))
        <p>
            {{ session('success')}}
        </p>
    @endif

</body>
</html>