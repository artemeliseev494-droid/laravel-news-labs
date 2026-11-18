<header style="background: #eef2f5; padding: 15px; margin-bottom: 20px; border-bottom: 2px solid #ccc;">
    <h2 style="margin: 0 0 10px 0;">Новостной сайт</h2>
    <nav style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <a href="{{ route('home') }}">Главная</a> |
        <a href="{{ route('category') }}">Категории</a>
        @auth
            @if(Auth::user()->isJournalist())
                | <a href="{{ route('journalist.index') }}" style="color: #b35900; font-weight: bold;">Журналист</a>
            @endif
            @if(Auth::user()->isAdmin())
                | <a href="{{ route('admin.index') }}" style="color: #990000; font-weight: bold;">Админ</a>
            @endif
        @endauth

        <span style="margin-left: auto;">
            @guest
                <a href="{{ route('login') }}">Вход</a> |
                <a href="{{ route('register') }}">Регистрация</a>
            @else
                Пользователь: <strong>{{ Auth::user()->login }}</strong> (Роль: <em>{{ Auth::user()->role?->name }}</em>)
                <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 10px;">
                    @csrf
                    <button type="submit">Выйти</button>
                </form>
            @endguest
        </span>
    </nav>
</header>
