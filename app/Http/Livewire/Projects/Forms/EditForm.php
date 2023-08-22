<?php

namespace App\Http\Livewire\Projects\Forms;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class EditForm extends Component
{
    public $project;

    public function rules()
    {
        return [
            'title' => 'required',
            'start_date' => 'required|date|after_or_equal:' . $this->project->start_date,
            'due_date' => 'required|after_or_equal:start_date',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function mount($project)
    {
        $this->project = $project;
        $this->title = $project->title;
        $this->start_date = $project->start_date;
        $this->due_date = $project->due_date;
        $this->note = $project->note;
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $data['title'] = $this->title;
        $data['start_date'] = $this->start_date;
        $data['due_date'] = $this->due_date;
        $data['note'] = $this->note;
        $data['edit_by'] = Auth::user()->id;
        
        $this->project->update($data);        
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function render()
    {
        return view('projects.components.edit-form');
    }
}

