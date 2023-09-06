@extends('layouts.app')
@section('bodycontent')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <a id="goBack" title="back" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a><br><br>
                <h5 class="font-bold text-center text-black">New Task</h5><br>                
                <livewire:calendar.forms.create-task :selectedDate=$selectedDate />
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.getElementById('goBack').addEventListener('click', function(event) {
        event.preventDefault();
        window.history.go(-2);
    });
</script>
@endpush