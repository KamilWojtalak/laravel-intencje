@push('head_scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'Europe/Warsaw',
                initialView: 'dayGridMonth',
                locale: 'pl', // Ustawienie lokalizacji na polską
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: false
                },
                events: [
                    @foreach ($events as $event)
                        {
                            title: '{{ $event->name }}',
                            start: '{{ $event->start_at->format('Y-m-d\TH:i:sP') }}',
                            end: '{{ $event->start_at->addHour()->format('Y-m-d\TH:i:sP') }}'
                        },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
@endpush

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Follower Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div id="calendar"></div>

            </div>
        </div>
    </div>
</x-app-layout>
