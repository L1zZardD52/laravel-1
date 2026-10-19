<!-- Подключаем общий каркас страницы (шапка и подвал). title - текст на вкладке браузера -->
<x-layout title="Главная — GameNews">

    <!-- Заголовок страницы -->
    <h1 class="page-title">Все новости</h1>

    <!-- Сетка карточек -->
    <section class="grid">

        <!-- Цикл foreach: берёт по одной новости из списка news и называет её item -->
        @forelse ($articles as $article)
            <x-news-card :article="$article" />
        @empty
            <p>Статей пока нет.</p>
        @endforelse

    </section>
    {{ $articles->links() }}
</x-layout>