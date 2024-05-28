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
        @endauth
    </ul>
</nav>
