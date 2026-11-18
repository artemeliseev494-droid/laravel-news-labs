@extends('layouts.app')

@section('title', 'Раздел журналиста — Новостной сайт')

@section('content')
<h2>Раздел: Журналист</h2>
<p>Интерфейс для написания и редактирования статей.</p>

<div style="display: flex; gap: 40px; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 320px;">
        <h3>Форма создания статьи</h3>
        <form action="{{ route('journalist.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="heading">Заголовок статьи:</label>
                <input type="text" id="heading" name="heading" value="{{ old('heading') }}" required>
            </div>

            <div class="form-group">
                <label for="categorie_id">Категория:</label>
                <select id="categorie_id" name="categorie_id" required>
                    <option value="" disabled selected>-- Выберите категорию --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="text">Полный текст статьи:</label>
                <textarea id="text" name="text" rows="8" required>{{ old('text') }}</textarea>
            </div>

            <button type="submit">Опубликовать статью</button>
        </form>
    </div>

    <div style="flex: 1; min-width: 320px;">
        <h3>Ваши статьи:</h3>
        @if($myArticles->isEmpty())
            <p>Вы пока не написали ни одной статьи.</p>
        @else
            <table border="1" cellpadding="6" cellspacing="0">
                <thead>
                    <tr>
                        <th>Заголовок</th>
                        <th>Категория</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myArticles as $item)
                        <tr>
                            <td><a href="{{ route('article.show', $item->id) }}">{{ $item->heading }}</a></td>
                            <td>{{ $item->category?->name }}</td>
                            <td>
                                @if($item->is_blocked)
                                    <span style="color: red;">Заблокирована</span>
                                @else
                                    <span style="color: green;">Опубликована</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('journalist.edit', $item->id) }}">Редактировать</a>
                                <form action="{{ route('journalist.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить статью?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: red; padding: 2px 6px; font-size: 12px;">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
