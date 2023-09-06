<?php

namespace App\Http\Livewire\Calendar\Forms;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateTask extends Component
{
    public $selectedDate;
    public $project_id;
    public $title;
    public $user_id;
    public $users;
    public $start_date;
    public $due_date;
    public $note;

    public function mount($selectedDate)
    {
        $this->start_date = $selectedDate;
        $this->project_id = '';
        $this->user_id = '';
        $this->users = User::all();
    }

    protected $rules = [
        'project_id' => 'required',
        'user_id' => 'required',
        'title' => 'required',
        'start_date' => 'required|after_or_equal:today',
        'due_date' => 'required|after_or_equal:start_date',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {   
        $validatedData = $this->validate($this->rules);
        $data['project_id'] = $this->project_id;
        $data['user_id'] = $this->user_id;
        $data['title'] = $this->title;
        $data['start_date'] = $this->start_date;
        $data['due_date'] = $this->due_date;
        $data['note'] = $this->note;
        $data['add_by'] = Auth::user()->id;

        $task = Task::create($data);
        if($task){
            return redirect()->route('tasks.index')->with('status', 'Task created successfully.');  
        }
        return redirect()->route('tasks.index')->with('delete', 'Task create faild, try again.');       
        
    }

    public function render()
    {
        $projects = Project::whereDate('due_date', '>=', now())->get();
        return view('calendar.components.create-task', compact('projects'));
    }
}

