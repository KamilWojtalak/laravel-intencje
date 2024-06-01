<x-public-layout>

    <style>
        table, tr, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 5px
        }
    </style>

    <table>
        <tr>
            <th>id</th>
            <th>Follower name</th>
            <th>Data mszy</th>
            <th>Jaka parafia</th>
            <th>Wiadomość intencji</th>
            <th>Status płatności</th>
            <th>session id</th>
            <th>price</th>
        </tr>
        @forelse ($orders as $order)
            <tr>
                <td>
                    {{ $order->id }}
                </td>
                <td>
                    {{ $order->follower->name }}
                </td>
                <td>
                    {{ $order->event->start_at->diffForHumans() }}

                </td>
                <td>
                    {{ $order->event->priest->name }}
                </td>
                <td>
                    {{ $order->message }}
                </td>
                <td>
                    {{ $order->payment->status }}
                </td>
                <td>
                    {{ $order->payment->session_id }}
                </td>
                <td>
                    {{ $order->payment->price }}
                </td>
            </tr>
        @empty
            <tr>
                <td>Brak</td>
            </tr>
        @endforelse
    </table>


</x-public-layout>
