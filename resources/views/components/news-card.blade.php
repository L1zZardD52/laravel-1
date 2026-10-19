@props(['article'])

<article class="card">
    <div class="card__body">
        <a href="{{ route('category.show', $article->category) }}" class="badge">{{ $article->category->name }}</a>

        <h3 class="card__title"><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>

        <p class="card__text">{{ \Illuminate\Support\Str::limit($article->content, 120) }}</p>

        <div class="card__meta">
            <span>Автор: {{ $article->user->login }}</span>
            <time>{{ $article->published_at->format('d.m.Y') }}</time>
        </div>
    </div>
</article>