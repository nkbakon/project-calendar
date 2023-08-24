@extends('layouts.app')
@section('bodycontent')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
            <a href="{{ route('projects.index') }}" title="back" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150" ><i class="fa-solid fa-arrow-left-long"></i></a><br><br>
                <br>
                <h1 class="text-center text-xl text-gray-700">Project Details</h1>
                <p class="text-left text-xl text-gray-700 font-bold">{{ $project->title }}</p><br>
                <div class="py-5 bg-gray-100 px-5 rounded-lg">                    
                    <div class="flex justify-between">
                        <div>
                            <p class="text-base font-bold text-gray-700">Project Overview</p>
                            <p class="font-bold text-2xl text-emerald-600"><span class="text-sm text-gray-700">ID:</span> #{{ $project->id }}</p>
                            @if($project->note != null)
                                <p class="text-gray-700">Note: {{ $project->note }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-700 font-bold">Start Date <br>
                                {{ $project->start_date }}
                            </p><br>
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 font-bold">Due Date <br>
                                        {{ $project->due_date }}
                                    </p>
                                </div>
                                <div>&nbsp;&nbsp;&nbsp;</div>
                                <div>
                                    <p class="text-4xl text-gray-700 font-bold">
                                        @php
                                            use Carbon\Carbon;

                                            $start = Carbon::parse(date("Y-m-d"));
                                            $due = Carbon::parse($project->due_date);

                                            $diff = $due->diffInDays($start);
                                            if ($diff < 0 || $due < $start) {
                                                $diff = 0;
                                            }
                                        @endphp
                                        {{ $diff }} days left
                                    </p>
                                </div>
                            </div>                            
                        </div>
                    </div> 
                </div><br>                               
                @if($project->user_ids != null)
                <p class="text-gray-700">Users</p>
                <div class="py-5 bg-gray-100 px-5 rounded-lg w-96">                    
                    @php
                        $user_ids = json_decode($project->user_ids);
                    @endphp
                    @for ($i = 0; $i < count($user_ids); $i++)
                    <p class="text-gray-700">{{ App\Models\User::find($user_ids[$i])->fname }} {{ App\Models\User::find($user_ids[$i])->lname }} ({{ App\Models\User::find($user_ids[$i])->username }})</p>
                    @endfor
                </div><br>
                @endif
                <div class="py-5 bg-gray-100 px-5 rounded-lg">                    
                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-700">Add By: {{ $project->addby->username }}</p> 
                            <p class="text-gray-700">Add Date: {{ $project->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-700">Last Edit By: {{ $project->editby->username }}</p> 
                            <p class="text-gray-700">Last Edit Date: {{ $project->updated_at->format('Y-m-d') }}</p>
                        </div>
                    </div> 
                </div><br>                                                                       
            </div>
        </div>
    </div>
</div>
@endsection