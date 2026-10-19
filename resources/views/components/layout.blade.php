<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- viewport - мета-тег, который позволяет адаптировать сайт под разные устройства -->
    <title>{{ $title ?? 'GameNews' }}</title> <!--$title - переменная, которая передается в компонент layout (если не указана, то используется значение по умолчанию) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- asset - хелпер, который формирует ссылку на файл в папке public -->
</head>
<body>
    <x-header /> <!-- x-header - компонент, который подключается в layout.blade.php (верхняя часть страницы) -->

    <main class="container main">
        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif
        {{ $slot }} <!-- $slot - переменная, которая передается в компонент layout и содержит контент страницы -->
    </main>

    <x-footer /> <!-- x-footer - компонент, который подключается в layout.blade.php (нижняя часть страницы) -->
</body>
</html>