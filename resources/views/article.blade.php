<x-layout :title="$article->title . ' — GameNews'">
    <article class="article">
        <a href="{{ route('category.show', $article->category) }}" class="badge">{{ $article->category->name }}</a>
        <h1 class="page-title">{{ $article->title }}</h1>
        <p class="subtitle">Автор: {{ $article->user->login }} · {{ $article->published_at->format('d.m.Y H:i') }}</p>

        <div class="article__text">{!! nl2br(e($article->content)) !!}</div>

        @auth
            @if (auth()->id() === $article->user_id)
                <p><a href="{{ route('articles.edit', $article) }}" class="btn">Редактировать</a></p>
            @endif
        @endauth
    </article>
</x-layout>