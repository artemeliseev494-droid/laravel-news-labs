@extends('layouts.app')

@section('title', 'Панель администратора — Новостной сайт')

@section('content')
<h2>Раздел: Администратор</h2>
<p>Панель управления статьями и ролями пользователей системы.</p>

<h3>1. Управление статьями</h3>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Категория</th>
            <th>Автор</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach($articles as $article)
            <tr style="{{ $article->is_blocked ? 'background-color: #fce8e6;' : '' }}">
                <td>{{ $article->id }}</td>
                <td><a href="{{ route('article.show', $article->id) }}">{{ $article->heading }}</a></td>
                <td>{{ $article->category?->name }}</td>
                <td>{{ $article->author?->login }}</td>
                <td>
                    @if($article->is_blocked)
                        <strong style="color: red;">Заблокирована</strong>
                    @else
                        <strong style="color: green;">Опубликована</strong>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.articles.toggleBlock', $article->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: {{ $article->is_blocked ? 'green' : 'orange' }}; font-size: 12px; padding: 3px 8px;">
                            {{ $article->is_blocked ? 'Разблокировать' : 'Блокировать' }}
                        </button>
                    </form>

                    <a href="{{ route('admin.articles.edit', $article->id) }}" style="margin: 0 5px;">Ред.</a>

                    <form action="{{ route('admin.articles.delete', $article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить статью навсегда?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: red; font-size: 12px; padding: 3px 8px;">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr style="margin: 30px 0;">

<h3>2. Изменение ролей пользователей</h3>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Логин</th>
            <th>Текущая роль</th>
            <th>Изменить роль</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td><strong>{{ $user->login }}</strong></td>
                <td>{{ $user->role?->name }}</td>
                <td>
                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                        @csrf
                        <select name="role_id">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" style="padding: 2px 8px; font-size: 12px;">Сохранить роль</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
