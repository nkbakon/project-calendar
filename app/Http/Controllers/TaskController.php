<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    
    public function index()
    {        
        return view('tasks.index');
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function destroy(Request $request)
    {
        $task = Task::find($request->data_id);
        if($task)
        {
            $task->delete();
            return redirect()->route('tasks.index')->with('delete', 'Task deleted successfully.');
        }
        else
        {
            return redirect()->route('tasks.index')->with('delete', 'No Task found!.');
        }    
    }
    
    public function view(Task $task)
    {
        return view('tasks.view', compact('task'));
    }

    
    
}