<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Folower create event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3>Dane o eventcie</h3>
                    <p>Nazwa: {{ $event->name }}</p>
                    <p>Kiedy: {{ $event->start_at->diffForHumans() }}</p>

                    <form action="{{ route('dashboard.follower.events.store') }}" method="post">
                        @csrf
                        <div class="">
                            <textarea name="message" id="message" cols="30" rows="10" placeholder="Tekst twojej intencji">Test, przykładowy tekst intencji za Wojciecha Bogacza</textarea>
                        </div>

                        <div class="">
                            <p>ile chcesz przekazać pieniędzy: (co łaska, min. 2 bo dostarczyciel płatności) (zł)</p>
                            <input type="number" name="price" id="price" min="2" value="2"> (zł)
                        </div>

                        <div class="">
                            <button>Przejdź do płatności</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
