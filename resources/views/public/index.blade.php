<x-public-layout>

    @if (auth()->guest() || auth()->user()->can('view-sign-to-priest-form'))
        wyszukaj parafie

        <form action="{{ route('register') }}" method="get">
            <select name="priest_id" id="priest_id">
                @foreach ($priests as $priest)
                    <option value="{{ $priest->id }}">{{ $priest->name }}</option>
                @endforeach
            </select>

            <button>Zapisz się</button>
        </form>
    @endif

</x-public-layout>
