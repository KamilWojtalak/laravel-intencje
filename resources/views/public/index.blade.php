<x-public-layout>
    wyszukaj parafie

    <form action="{{ route('register') }}" method="get">
        <select name="priest_id" id="priest_id">
            @foreach ($priests as $priest)
                <option value="{{ $priest->id }}">{{ $priest->name }}</option>
            @endforeach
        </select>

        <button>Zapisz się</button>
    </form>

</x-public-layout>
