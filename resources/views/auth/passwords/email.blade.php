<<<<<<< HEAD
@extends('layout.public')

@section('content')
    <h2>Redefinição senha</h2>

    <form action="{{ route('password.email') }}" method="post">
        <label for="login">Matrícula:</label>
        <input type="text" name="login" id="login">

        <button type="submit" class="submit">Redefinir</button>

        <div class="remember">
            <a href="{{ url('login') }}">Fazer login?</a>
        </div>

    </form>
@endsection
=======
@extends('layout.public')

@section('content')
    <h2>Redefinição senha</h2>

    <form action="{{ route('password.email') }}" method="post">
        <label for="login">Matrícula:</label>
        <input type="text" name="login" id="login">

        <button type="submit" class="submit">Redefinir</button>

        <div class="remember">
            <a href="{{ Asset::get('login') }}">Fazer login?</a>
        </div>

    </form>
@endsection
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
