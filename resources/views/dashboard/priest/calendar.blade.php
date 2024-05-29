@push('head_scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script>
        // TODO zmień locale w jaki wyświetlają się daty, na polski
        // TODO trzeba dodać eventy z bazy danych
        // TODO trzeba dodać facotries i seedery dla tych eventow i je przestować
        // TODO trzeba dodać rozwiniecie nazwy po najechaniu myszkiem
        // TODO Trzeba dodać możliwość umawiania się na dany termin

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
                events: [{
                        title: 'Przykładowa msza o 8:00',
                        start: '{{ $date = now()->addDay()->setHour(8)->setMinutes(0)->format('Y-m-d\TH:i:sP') }}',
                        end: '2024-05-30'
                    },
                    {
                        title: 'Przykładowa msza o 12:00',
                        start: '{{ $date = now()->addDay()->setHour(12)->setMinutes(0)->format('Y-m-d\TH:i:sP') }}',
                        end: '2024-05-30'
                    },
                    {
                        title: 'Przykładowa msza o 20:00',
                        start: '{{ $date = now()->addDay()->setHour(20)->setMinutes(0)->format('Y-m-d\TH:i:sP') }}',
                        end: '2024-05-30'
                    }
                ]
            });
            calendar.render();
        });
    </script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Priest Calendar') }}
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
