<x-layout title="Редактирование — GameNews">
    <h1 class="page-title">Редактирование статьи</h1>
    <x-article-form :action="route('articles.update', $article)" method="PUT" button="Сохранить" :article="$article" :categories="$categories" />
</x-layout>