<header class="header">
    <div class="container header__inner">

        {{-- Логотип ведёт на главную страницу. --}}
        <a href="{{ route('home') }}" class="logo">Game<span>News</span></a>

        <nav class="nav">
            {{-- Главная страница доступна всем посетителям. --}}
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                Главная
            </a>

            {{-- Ссылка на категории доступна всем посетителям. --}}
            <a
                href="{{ route('category') }}"
                class="{{ request()->routeIs('category', 'category.show') ? 'active' : '' }}"
            >
                Категория
            </a>

            {{-- Закрытые ссылки отображаются только после входа в аккаунт. --}}
            @auth
                {{-- Журналист может перейти к форме и списку своих статей. --}}
                @if (auth()->user()->role?->name === 'journalist')
                    <a
                        href="{{ route('journalist') }}"
                        class="{{ request()->routeIs('journalist', 'articles.edit') ? 'active' : '' }}"
                    >
                        Журналист
                    </a>
                @endif

                {{-- Администратор может перейти в панель управления. --}}
                @if (auth()->user()->role?->name === 'admin')
                    <a
                        href="{{ route('admin.index') }}"
                        class="{{ request()->routeIs('admin.*') ? 'active' : '' }}"
                    >
                        Админка
                    </a>
                @endif

                {{-- Показываем логин вошедшего пользователя. --}}
                <span class="nav__user">{{ auth()->user()->login }}</span>

                {{-- Выход отправляется POST-запросом, как требует Laravel. --}}
                <form action="{{ route('logout') }}" method="POST" class="nav__form">
                    @csrf

                    <button type="submit" class="nav__btn">
                        Выйти
                    </button>
                </form>
            @endauth

            {{-- Гостям показываем ссылки для входа и регистрации. --}}
            @guest
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
                    Вход
                </a>

                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">
                    Регистрация
                </a>
            @endguest
        </nav>
    </div>
</header>