<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Folower index event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Eventy: ...</p>

                    @forelse ($events as $event)
                        <li>{{ $event->name }} | {{ $event->start_at->diffForHumans() }}</li>
                    @empty
                        <li>Brak eventów</li>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
