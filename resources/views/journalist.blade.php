<x-layout title="Журналист — GameNews">
    <h1 class="page-title">Новая статья</h1>

    <x-article-form :action="route('articles.store')" :categories="$categories" />

    <h2 class="section-title">Мои статьи</h2>
    @if ($myArticles->isEmpty())
        <p>Вы ещё не написали ни одной статьи.</p>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Заголовок</th><th>Категория</th><th>Дата</th><th>Действия</th></tr></thead>
                <tbody>
                    @foreach ($myArticles as $a)
                        <tr>
                            <td><a href="{{ route('articles.show', $a) }}">{{ $a->title }}</a></td>
                            <td>{{ $a->category->name }}</td>
                            <td>{{ $a->published_at?->format('d.m.Y') }}</td>
                            <td><a href="{{ route('articles.edit', $a) }}" class="btn btn--sm">Редактировать</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-layout>
