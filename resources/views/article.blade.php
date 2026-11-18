@extends('layouts.app')

@section('title', $article->heading . ' — Новостной сайт')

@section('content')
<p><a href="{{ route('home') }}">&larr; Вернуться на главную</a> | <a href="{{ route('category', $article->category->id) }}">Категория: {{ $article->category->name }}</a></p>

<article>
    <h1>{{ $article->heading }}</h1>
    <div class="article-meta">
        Категория: <strong>{{ $article->category->name }}</strong> | 
        Автор: <strong>{{ $article->author?->login ?? 'Аноним' }}</strong> | 
        Опубликовано: {{ $article->created_at->format('d.m.Y H:i') }}
    </div>

    <div style="font-size: 16px; line-height: 1.6; margin: 20px 0; white-space: pre-line;">
        {{ $article->text }}
    </div>
</article>

<hr>
<p>
    <a href="{{ route('home') }}">&larr; Ко всем новостям</a>
    @auth
        @if(Auth::id() === $article->user_id)
            | <a href="{{ route('journalist.edit', $article->id) }}">Редактировать статью</a>
        @elseif(Auth::user()->isAdmin())
            | <a href="{{ route('admin.articles.edit', $article->id) }}">Редактировать как админ</a>
        @endif
    @endauth
</p>
@endsection
