<!-- Шапка сайта: логотип и меню -->
<header class="header">
    <div class="container header__inner">

        <!-- Логотип. Ссылка ведёт на главную -->
        <a href="{{ route('home') }}" class="logo">Game<span>News</span></a>

        <!-- Меню. Если мы на этой странице, ссылке добавляется класс active (подсветка) -->
        <nav class="nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('category') }}" class="{{ request()->routeIs('category') ? 'active' : '' }}">Категория</a>
            <a href="{{ route('journalist') }}" class="{{ request()->routeIs('journalist') ? 'active' : '' }}">Журналист</a>
            <a href="{{ route('admin') }}" class="{{ request()->routeIs('admin') ? 'active' : '' }}">Админ</a>
        </nav>

    </div>
</header>