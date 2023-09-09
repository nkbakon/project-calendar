@extends('layouts.app')
@section('bodycontent')
<h1 class="text-center font-bold text-gray-600">Welcome {{ auth()->user()->fname }} {{ auth()->user()->lname }} ({{ auth()->user()->username }})</h1>
<h1 class="text-center text-gray-600">Department : @if(auth()->user()->department_id != null)
                        {{ auth()->user()->department->name }}
                @else
                    None
                @endif
</h1><br>

<div class="py-12">
  <div class="sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
      <div class="flex justify-between">                               
        <div>
          <p class="text-gray-700">Users</p>
          <div class="py-5 bg-gray-100 px-5 shadow-lg rounded-lg w-96">                    
            @php
              $users = App\Models\User::all();
            @endphp
            @foreach ($users as $user)
            <p class="text-gray-700">{{ $user->fname }} {{ $user->lname }} ({{ $user->username }})</p>
            @endforeach
          </div><br>
        </div>
        <div>
          <p class="text-gray-700">Departments</p>
          <div class="py-5 bg-gray-100 px-5 shadow-lg rounded-lg w-96">                    
              @php
                $departments = App\Models\Department::all();
              @endphp
              @foreach ($departments as $department)
                <p class="text-gray-700 font-bold">{{ $department->name }}: </p>
                @foreach($users as $user)
                  @if($user->department_id == $department->id)
                    <span class="pl-6 text-gray-700">{{ $user->fname }} {{ $user->lname }} ({{ $user->username }}) </span><br>
                  @endif
                @endforeach              
              @endforeach
          </div><br>
        </div>
      </div><br>
      <p class="text-gray-700">Projects</p>
      <div class="max-h-[800px] overflow-y-auto py-5 bg-white px-5 rounded-lg">
        @php
          $projects = App\Models\Project::all();
        @endphp
        <table class="w-full shadow-lg text-base text-left text-gray-700 dark:text-gray-400">
          <thead class="text-sm text-gray-800 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="">
              <th class="py-3 px-4">
                Title
              </th>
              <th class="py-3 px-4">
                Due Date
              </th>
              <th class="py-3 px-4">
                Days Left
              </th>
              <th class="py-3 px-4">
                View
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($projects as $project)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <td class="py-3 px-4">
                {{ $project->title }}
              </td>
              <td class="py-3 px-4">
                {{ $project->due_date }}
              </td>
              <td class="py-3 px-4">
                @php 
                  $start = Carbon\Carbon::parse(date("Y-m-d"));
                  $due = Carbon\Carbon::parse($project->due_date);
          
                  $diff = $due->diffInDays($start);
                  if ($diff < 0 || $due < $start) {
                      $diff = 0;
                  }
    
                  $project->daysLeft = $diff;
                @endphp
                {{ $project->daysLeft }} days left
              </td>
              <td class="py-3 px-4">                 
                <a href="{{ route('projects.view', $project) }}" title="view" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-regular fa-eye"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div><br>
      @if (auth()->user()->type != 'Worker')      
      <div class="justify-center rounded overflow-hidden">
        <div class="px-6 py-4 text-center">
          <div id='calendar' class="shadow-lg rounded"></div>
          @php
            $projects = App\Models\Project::whereNotNull('due_date')->get()->map(function($project) {
              return [
                  'title' => $project->title,
                  'start' => Carbon\Carbon::parse($project->due_date)->format('Y-m-d'),
                  'url' => route('projects.view', $project),
                  'color' => '#3498db',
              ];
            });

            $tasks = App\Models\Task::whereNotNull('due_date')->get()->map(function($task) {
                return [
                    'title' => $task->title,
                    'start' => Carbon\Carbon::parse($task->due_date)->format('Y-m-d'),
                    'url' => route('tasks.view', $task),
                    'color' => '#2ecc71',
                ];
            });

            $events = array_merge($projects->toArray(), $tasks->toArray()); 
          @endphp
        </div>
      </div>
      @endif
    </div>
  </div>
</div><br>
@endsection

@if (auth()->user()->type != 'Worker')
@push('js')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            events: @json($events),
            initialView: 'dayGridMonth',
        });
        calendar.render();
    });
</script>
@endpush
@endif