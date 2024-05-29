@push('head_scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [{ // this object will be "parsed" into an Event Object
                    title: 'The Title', // a property!
                    start: '2024-05-30', // a property!
                    end: '2024-05-30' // a property! ** see important note below about 'end' **
                }]
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
