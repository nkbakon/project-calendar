@extends('layouts.app')
@section('bodycontent')
@if (auth()->user()->type != 'Worker')
<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto md:px-6">
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 mr-6 space-x-8 text-sm font-medium">
                <li>
                    <a href="{{ route('calendar.index') }}" class="px-3 py-1 flex space-x-2 mt-5 rounded-md border border-gray-50 cursor-pointer hover:bg-gray-400 hover:border-gray-500 hover:text-gray-50">All</a>
                </li>
                <li>
                    <a href="{{ route('calendar.personal') }}" class="bg-gray-500 border-gray-600 text-white px-3 py-1 flex space-x-2 mt-5 rounded-md border border-gray-50 cursor-pointer hover:bg-gray-400 hover:border-gray-500 hover:text-gray-50">Personal</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <button id="monthView" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Month</button>
                <button id="weekView" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Week</button>
                <button id="dayView" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Day</button>
                <br>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            events: @json($events),
            initialView: 'dayGridMonth',
            selectable: 'true',
            selectHelper: 'true',
            select: function(info) {
                // Extract the selected date from the 'info' object
                var selectedDate = info.start.toISOString();

                // Redirect to the 'calendar.add' route with the selected date as a query parameter
                window.location.href = "{{ route('calendar.add') }}?selectdate=" + selectedDate;
            }
        });
        calendar.render();

        // Get buttons
        var monthViewBtn = document.getElementById('monthView');
        var weekViewBtn = document.getElementById('weekView');
        var dayViewBtn = document.getElementById('dayView');

        // Add event listeners to buttons
        monthViewBtn.addEventListener('click', function() {
            calendar.changeView('dayGridMonth');
        });

        weekViewBtn.addEventListener('click', function() {
            calendar.changeView('timeGridWeek');
        });

        dayViewBtn.addEventListener('click', function() {
            calendar.changeView('timeGridDay');
        });
    });
</script>
@endpush