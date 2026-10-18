<!-- Подключаем общий каркас страницы (шапка и подвал). title - текст на вкладке браузера -->
<x-layout title="Главная — GameNews">

    <!-- Заголовок страницы -->
    <h1 class="page-title">Все новости</h1>

    <!-- Сетка карточек -->
    <section class="grid">

        <!-- Цикл foreach: берёт по одной новости из списка news и называет её item -->
        @foreach ($news as $item)

            <!-- Выводим одну карточку и передаём ей новость item (двоеточие перед item обязательно) -->
            <x-news-card :item="$item" />

        @endforeach

    </section>
</x-layout>