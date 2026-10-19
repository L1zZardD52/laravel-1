<header class="header">
    <div class="container header__inner">

        <a href="{{ route('home') }}" class="logo">Game<span>News</span></a>

        <nav class="nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('category') }}" class="{{ request()->routeIs('category', 'category.show') ? 'active' : '' }}">Категория</a>
            <a href="{{ route('journalist') }}" class="{{ request()->routeIs('journalist', 'articles.edit') ? 'active' : '' }}">Журналист</a>

            @auth
                <span class="nav__user">{{ auth()->user()->login }}</span>
                <form action="{{ route('logout') }}" method="POST" class="nav__form">
                    @csrf
                    <button type="submit" class="nav__btn">Выйти</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Вход</a>
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Регистрация</a>
            @endguest
        </nav>

    </div>
</header>