@extends('layouts.app')

@section('title', 'Главная страница — Новостной сайт')

@section('content')
<h2>Главная страница</h2>
<p>Здесь выводятся все опубликованные новости из базы данных.</p>

<div style="margin-bottom: 20px;">
    <strong>Рубрики:</strong>
    <a href="{{ route('home') }}">Все</a> |
    @foreach($categories as $cat)
        <a href="{{ route('category', $cat->id) }}">{{ $cat->name }}</a> ({{ $cat->texts_count }})
        @if(!$loop->last) | @endif
    @endforeach
</div>

<hr>

@if($articles->isEmpty())
    <p>Статей пока нет.</p>
@else
    @foreach($articles as $article)
        <div class="article-item">
            <h3><a href="{{ route('article.show', $article->id) }}">{{ $article->heading }}</a></h3>
            <div class="article-meta">
                Категория: <span class="badge">{{ $article->category?->name ?? 'Без категории' }}</span> | 
                Автор: <strong>{{ $article->author?->login ?? 'Аноним' }}</strong> | 
                Дата: {{ $article->created_at->format('d.m.Y H:i') }}
            </div>
            <p>{{ Str::limit($article->text, 150) }}</p>
            <a href="{{ route('article.show', $article->id) }}">Читать полностью &rarr;</a>
        </div>
    @endforeach

    <div style="margin-top: 20px;">
        {{ $articles->links() }}
    </div>
@endif
@endsection
