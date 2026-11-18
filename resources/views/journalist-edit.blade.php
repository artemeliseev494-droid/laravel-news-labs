@extends('layouts.app')

@section('title', 'Редактирование статьи — Новостной сайт')

@section('content')
<h2>Редактирование статьи #{{ $article->id }}</h2>
<p><a href="{{ route('journalist.index') }}">&larr; Назад в раздел журналиста</a></p>

<form action="{{ route('journalist.update', $article->id) }}" method="POST">
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
        <label for="text">Полный текст статьи:</label>
        <textarea id="text" name="text" rows="10" required>{{ old('text', $article->text) }}</textarea>
    </div>

    <button type="submit">Сохранить изменения</button>
    <a href="{{ route('journalist.index') }}" style="margin-left: 10px;">Отмена</a>
</form>
@endsection
