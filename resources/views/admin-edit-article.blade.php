@extends('layouts.app')

@section('title', 'Админ — Редактирование статьи — Новостной сайт')

@section('content')
<h2>Админ: Редактирование статьи #{{ $article->id }}</h2>
<p><a href="{{ route('admin.index') }}">&larr; Назад в админ-панель</a></p>

<form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="heading">Заголовок статьи:</label>
        <input type="text" id="heading" name="heading" value="{{ old('heading', $article->heading) }}" required>
    </div>

    <div class="form-group">
        <label for="categorie_id">Категория:</label>
        <select id="categorie_id" name="categorie_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('categorie_id', $article->categorie_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Автор статьи:</label>
        <input type="text" value="{{ $article->author?->login ?? 'Аноним' }}" disabled readonly style="background: #eee;">
    </div>

    <div class="form-group">
        <label for="text">Полный текст статьи:</label>
        <textarea id="text" name="text" rows="10" required>{{ old('text', $article->text) }}</textarea>
    </div>

    <button type="submit">Сохранить</button>
    <a href="{{ route('admin.index') }}" style="margin-left: 10px;">Отмена</a>
</form>
@endsection
