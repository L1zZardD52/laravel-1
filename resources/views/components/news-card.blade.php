@props(['item'])

<!-- Одна карточка новости. Данные приходят в переменной item (одна новость из списка) -->
<article class="card">

    <!-- Место под картинку -->
    <div class="card__img">Фото</div>

    <div class="card__body">
        <!-- Категория новости -->
        <span class="badge">{{ $item['category'] }}</span>

        <!-- Заголовок новости -->
        <h3 class="card__title">{{ $item['title'] }}</h3>

        <!-- Текст новости -->
        <p class="card__text">{{ $item['text'] }}</p>

        <!-- Дата новости -->
        <time class="card__date">{{ $item['date'] }}</time>
    </div>
</article>