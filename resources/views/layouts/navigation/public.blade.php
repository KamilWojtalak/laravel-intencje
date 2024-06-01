<nav>
    <ul>
        @guest
            <li>
                <a href="{{ route('register-priest') }}">Register proboszcz</a>
            </li>
            <li>
                <a href="{{ route('register') }}">Register user</a>
            </li>
            <li>
                <a href="{{ route('login') }}">Login</a>
            </li>
        @endguest
        @auth
            <li>
                <a href="{{ route('logout') }}">Logout</a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
        @endauth

        @env(['local', 'develop'])
            <li>
                <a href="{{ route('test.users.index') }}">
                    Zaloguj się jako testowy user (tylko na developie, nie będzie tego
                    na prodzie)
                </a>
            </li>
        @endenv

    </ul>
</nav>
