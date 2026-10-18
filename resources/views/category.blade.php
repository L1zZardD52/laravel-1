<!-- То же самое, что главная, только заголовок Категория: {{ $name }} показывает выбранную категорию 
в $news приходят уже отфильтрованные новости-->
<x-layout title="Категория — GameNews">
    <h1 class="page-title">Категория: {{ $name }}</h1>
    <p class="subtitle">Новости только из выбранной категории.</p>

    <section class="grid">
        @foreach ($news as $item)
            <x-news-card :item="$item" />
        @endforeach
    </section>
</x-layout>