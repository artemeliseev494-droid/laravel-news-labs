@extends('layouts.app')

@section('title', 'Категории — Новостной сайт')

@section('content')
<h2>Раздел: Категории</h2>
<p>Отображаются статьи выбранной категории из базы данных.</p>

<div style="display: flex; gap: 30px; flex-wrap: wrap;">
    <div style="min-width: 200px;">
        <h3>Список категорий:</h3>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('category', $category->id) }}" style="{{ $currentCategory && $currentCategory->id === $category->id ? 'font-weight: bold; color: black;' : '' }}">
                        {{ $category->name }} ({{ $category->texts_count }})
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div style="flex-grow: 1; max-width: 700px;">
        <h3>
            @if($currentCategory)
                Статьи в категории «{{ $currentCategory->name }}»:
            @else
                Выберите категорию
            @endif
        </h3>

        @if($articles->isEmpty())
            <p>В этой категории пока нет опубликованных статей.</p>
        @else
            @foreach($articles as $article)
                <div class="article-item">
                    <h3><a href="{{ route('article.show', $article->id) }}">{{ $article->heading }}</a></h3>
                    <div class="article-meta">
                        Категория: {{ $article->category->name }} | 
                        Автор: {{ $article->author?->login ?? 'Аноним' }} | 
                        Дата: {{ $article->created_at->format('d.m.Y H:i') }}
                    </div>
                    <p>{{ Str::limit($article->text, 120) }}</p>
                    <a href="{{ route('article.show', $article->id) }}">Читать далее</a>
                </div>
            @endforeach

            <div style="margin-top: 15px;">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
