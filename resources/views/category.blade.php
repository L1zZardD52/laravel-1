<x-layout :title="'Категория ' . $category->name . ' — GameNews'">
    <h1 class="page-title">Категория: {{ $category->name }}</h1>
    <p class="subtitle">Новости только из выбранной категории.</p>

    <div class="chips">
        @foreach ($categories as $c)
            <a href="{{ route('category.show', $c) }}" class="chip {{ $c->id === $category->id ? 'chip--active' : '' }}">{{ $c->name }}</a>
        @endforeach
    </div>

    <section class="grid">
        @forelse ($articles as $article)
            <x-news-card :article="$article" />
        @empty
            <p>В этой категории пока нет статей.</p>
        @endforelse
    </section>

    {{ $articles->links() }}
</x-layout>