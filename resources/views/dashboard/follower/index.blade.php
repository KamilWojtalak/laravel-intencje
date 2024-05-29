<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard follower') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2>Twoj ksiądz to: {{ $priest->name }}.</h2>
                    @if (Auth::user()->isAcceptedByPriest())
                        <p>Zostałeś zaakceptowany przez księdza, teraz możesz wysłać swoją intecję</p>

                        <a href="{{ route('dashboard.follower.calendar') }}">Wybierz mszę, na którą chcesz podać intencję</a>
                    @else
                        <p> Czekaj za zostaniesz zaakcpetowany. Wiadomość o twoją chęć dołączenia została wysłana do
                            księdza.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
