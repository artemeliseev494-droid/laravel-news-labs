@extends('layouts.app')

@section('title', 'Вход — Новостной сайт')

@section('content')
<h2>Вход в систему</h2>
<p>Авторизация по логину и паролю.</p>

<form action="{{ route('login') }}" method="POST" style="max-width: 400px;">
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
        <label>
            <input type="checkbox" name="remember"> Запомнить меня
        </label>
    </div>

    <button type="submit">Войти</button>
</form>

<p style="margin-top: 15px;">
    Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
</p>

<div style="background: #f7f7f7; padding: 10px; border: 1px solid #ddd; margin-top: 20px; max-width: 400px; font-size: 13px;">
    <strong>Тестовые данные:</strong><br>
    Администратор: <code>admin</code> / <code>qwerty123</code><br>
    Журналист: <code>journalist</code> / <code>qwerty123</code><br>
    Пользователь: <code>user</code> / <code>qwerty123</code>
</div>
@endsection
