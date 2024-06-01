<x-public-layout>

    <ul>
        @forelse ($orders as $order)
            {{ $order->id }}
        @empty
            <li>Brak orderów</li>
        @endforelse
    </ul>

</x-public-layout>
