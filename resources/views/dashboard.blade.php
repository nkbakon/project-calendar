@extends('layouts.app')
@section('bodycontent')
<h1 class="text-center font-bold text-gray-600">Welcome {{ auth()->user()->fname }} {{ auth()->user()->lname }} ({{ auth()->user()->username }})</h1>
<h1 class="text-center text-gray-600">Department : @if(auth()->user()->department_id != null)
                        {{ auth()->user()->department->name }}
                @else
                    None
                @endif
</h1><br>
@if (auth()->user()->type != 'Worker')
<div class="py-12">
  <div class="sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
      <div class="flex space-x-40">
        <a href="{{ route('tasks.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-emerald-600">{{ App\Models\Task::where('status', 'Not Started')->count() }}</div>
              <p class="text-gray-700">
                Tasks to start
              </p>
            </div>
          </div>
        </a>
        <a href="{{ route('tasks.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-emerald-600">{{ App\Models\Task::where('status', 'In Progress')->count() }}</div>
              <p class="text-gray-700">
                Tasks in progress
              </p>
            </div>
          </div>
        </a>
      </div><br>
      <div class="flex space-x-40">
        <a href="{{ route('tasks.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-emerald-600">{{ App\Models\Task::where('status', 'Waiting Approval')->count() }}</div>
              <p class="text-gray-700">
                Tasks to approve
              </p>
            </div>
          </div>
        </a>
        <a href="{{ route('todo.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-emerald-600">{{ App\Models\Todo::where('status', 'Active')->count() }}</div>
              <p class="text-gray-700">
                To do
              </p>
            </div>
          </div>
        </a>
      </div><br>
    </div>
  </div>
</div><br>
@else
<div class="py-12">
  <div class="sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
      <div class="flex space-x-40">
        <a href="{{ route('tasks.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-emerald-600">{{ App\Models\Task::where('status', 'Not Started')->where('user_id', auth()->user()->id)->count() }}</div>
              <p class="text-gray-700">
                Tasks to start
              </p>
            </div>
          </div>
        </a>
        <a href="{{ route('tasks.index') }}">
          <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
            <div class="px-6 py-4 text-center">
              <div class="font-bold text-5xl text-emerald-600">{{ App\Models\Task::where('status', 'In Progress')->where('user_id', auth()->user()->id)->count() }}</div>
              <p class="text-gray-700">
                Tasks in progress
              </p>
            </div>
          </div>
        </a>
      </div><br>
    </div>
  </div>
</div><br>
@endif
@endsection
