@push('head_scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    </script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Priest') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2>Twoi NIE zaakceptowani followersi ({{ $unacceptedFollowers->count() }})</h2>
                    <ul>
                        @forelse ($unacceptedFollowers as $follower)
                            <li>
                                {{ $follower->name }}
                                <span style="color: green">
                                    <form action="{{ route('dashboard.priest.accept', $follower) }}" method="post">
                                        @csrf
                                        <button>(Akceptuj)</button>
                                    </form>
                                </span>
                            </li>
                        @empty
                            <li>Nikt się jeszcze nie zapisał</li>
                        @endforelse
                    </ul>
                </div>

                <div class="p-6 text-gray-900">
                    <h2>Twoi zaakceptowani followersi ({{ $acceptedFollowers->count() }})</h2>
                    <ul>
                        @forelse ($acceptedFollowers as $follower)
                            <li>
                                {{ $follower->name }}
                            </li>
                        @empty
                            <li>Nikt się jeszcze nie zapisał</li>
                        @endforelse
                    </ul>
                </div>

                <div id="calendar"></div>

            </div>
        </div>
    </div>
</x-app-layout>
