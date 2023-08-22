<?php

namespace App\Http\Livewire\Tasks\Forms;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EditForm extends Component
{
    public $task;

    public function rules()
    {
        return [
            'project_id' => 'required',
            'user_id' => 'required',
            'title' => 'required',
            'start_date' => 'required|date|after_or_equal:' . $this->task->start_date,
            'due_date' => 'required|after_or_equal:start_date',
            'status' => 'required',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function mount($task)
    {
        $this->task = $task;
        $this->users = User::all();
        $this->projects = Project::whereDate('due_date', '>=', $task->start_date)->get();
        $this->project_id = $task->project_id;
        $this->user_id = $task->user_id;
        $this->title = $task->title;
        $this->start_date = $task->start_date;
        $this->due_date = $task->due_date;
        $this->status = $task->status;
        $this->note = $task->note;
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $data['project_id'] = $this->project_id;
        $data['user_id'] = $this->user_id;
        $data['title'] = $this->title;
        $data['start_date'] = $this->start_date;
        $data['due_date'] = $this->due_date;
        $data['status'] = $this->status;
        $data['note'] = $this->note;
        $data['edit_by'] = Auth::user()->id;
        
        $this->task->update($data);        
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function render()
    {
        return view('tasks.components.edit-form');
    }
}

