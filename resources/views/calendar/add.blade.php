@extends('layouts.app')
@section('bodycontent')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h5 class="font-bold text-center text-sm text-gray-500">Selected Date: {{ $selectedDate }}</h5><br><br>
                <h5 class="font-bold text-black">Select Type</h5><br>
                <form method="POST" action="{{ route('calendar.update', $selectedDate) }}">
                    @csrf
                    @method('put') 
                    <select name="type" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="Project">Project</option>
                        <option value="Task">Task</option>
                    </select>
                    <br>                  
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection