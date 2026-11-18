@extends('layouts.app')

@section('title', 'Регистрация — Новостной сайт')

@section('content')
<h2>Регистрация нового пользователя</h2>
<p>Регистрация выполняется только по логину и паролю.</p>

<form action="{{ route('register') }}" method="POST" style="max-width: 400px;">
    @csrf

    <div class="form-group">
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Подтверждение пароля:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>

    <button type="submit">Зарегистрироваться</button>
</form>

<p style="margin-top: 15px;">
    Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
</p>
@endsection
