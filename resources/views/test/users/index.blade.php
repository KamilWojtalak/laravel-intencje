@foreach ($users as $user)
    <li>{{ $user->name }} | ({{ $user->getRoleName() }}) | <a href="{{ route('test.users.store', $user) }}">Zaloguj się jako ten user</a></li>
@endforeach
