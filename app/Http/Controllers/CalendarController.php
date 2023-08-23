<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $projects = Project::whereNotNull('due_date')->get()->map(function($project) {
            return [
                'title' => $project->title,
                'start' => Carbon::parse($project->due_date)->format('Y-m-d'),
                'url' => route('projects.index'),
                'color' => '#3498db',
            ];
        });

        $tasks = Task::whereNotNull('due_date')->get()->map(function($task) {
            return [
                'title' => $task->title,
                'start' => Carbon::parse($task->due_date)->format('Y-m-d'),
                'url' => route('tasks.view', $task),
                'color' => '#2ecc71',
            ];
        });

        $events = array_merge($projects->toArray(), $tasks->toArray());

        return view('calendar.index', compact('events'));
    }

    public function personal()
    {
        $user = Auth::user()->id;

        
        $projects = Project::whereNotNull('due_date')->get()->filter(function ($project) use ($user) {
            if ($project->user_ids != null) {
                $userIds = json_decode($project->user_ids);

                return in_array($user, $userIds);
            }
        })->map(function($project) {
            return [
                'title' => $project->title,
                'start' => Carbon::parse($project->due_date)->format('Y-m-d'),
                'url' => route('projects.index'),
                'color' => '#3498db',
            ];
        });

        $tasks = Task::whereNotNull('due_date')->where('user_id', $user)->get()->map(function($task) {
            return [
                'title' => $task->title,
                'start' => Carbon::parse($task->due_date)->format('Y-m-d'),
                'url' => route('tasks.view', $task),
                'color' => '#2ecc71',
            ];
        });

        $events = array_merge($projects->toArray(), $tasks->toArray());

        return view('calendar.personal', compact('events'));
    }
}
