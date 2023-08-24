@extends('layouts.app')
@section('bodycontent')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
            <a href="{{ route('tasks.index') }}" title="back" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150" ><i class="fa-solid fa-arrow-left-long"></i></a><br><br>
                <br>
                <h1 class="text-left text-xl text-gray-700">Task Details</h1><br>
                <p class="text-center text-xl text-gray-700">Task Title: <strong class="text-emerald-600">{{ $task->title }}</strong></p>
                <p class="font-bold text-5xl text-emerald-600"><span class="text-sm text-gray-700">ID:</span> #{{ $task->id }}</p><br>
                <div class="flex justify-between">
                    <p class="text-xl text-gray-700">Start Date: <span class="font-bold">{{ $task->start_date }}</span></p>
                    <p class="text-xl text-gray-700">Due Date: 
                        <span class="font-bold">
                            {{ $task->due_date }} 
                            @php
                                use Carbon\Carbon;

                                $start = Carbon::parse(date("Y-m-d"));
                                $due = Carbon::parse($task->due_date);

                                $diff = $due->diffInDays($start);
                                if ($diff < 0 || $due < $start) {
                                    $diff = 0;
                                }
                            @endphp
                            ({{ $diff }} days left)
                        </span>
                    </p>
                </div><br> 
                <p class="text-gray-700">Project: {{ $task->project->title }}</p>
                <p class="text-gray-700">User:  {{ $task->user->fname }} {{ $task->user->lname }} ({{ $task->user->username }})</p>
                <p class="text-gray-700">Status: {{ $task->status }}</p>
                @if($task->note != null)
                    <p class="text-gray-700">Note: {{ $task->note }}</p>
                @endif
                <br>
                <div class="flex justify-between">
                    <div>
                        <p class="text-gray-700">Add By: {{ $task->addby->username }}</p> 
                        <p class="text-gray-700">Add Date: {{ $task->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-700">Last Edit By: {{ $task->editby->username }}</p> 
                        <p class="text-gray-700">Last Edit Date: {{ $task->updated_at->format('Y-m-d') }}</p>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</div>
@endsection