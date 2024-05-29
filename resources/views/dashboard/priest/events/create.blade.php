<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <form action="{{ route('dashboard.priest.events.store') }}" method="post">
                    @csrf
                    <div class="">
                        Name
                        <input type="name" name="name">
                    </div>
                    <div class="">
                        Dzień
                        <input type="date" name="" id="">
                    </div>
                    <div class="">
                        Godzina
                        <input type="number" name="hourd" id="hourd">
                    </div>
                    <div class="">
                        Minuty
                        <input type="minutes" name="minutes" id="minutes">
                    </div>

                    <button>Stwórz mszę</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
