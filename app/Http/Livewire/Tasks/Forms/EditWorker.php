<?php

namespace App\Http\Livewire\Tasks\Forms;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EditWorker extends Component
{
    public $task;

    public function rules()
    {
        return [
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
        $this->status = $task->status;
        $this->note = $task->note;
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $data['status'] = $this->status;
        $data['note'] = $this->note;
        $data['edit_by'] = Auth::user()->id;
        
        $this->task->update($data);        
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function render()
    {
        return view('tasks.components.edit-worker');
    }
}

