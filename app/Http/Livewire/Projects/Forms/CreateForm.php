<?php

namespace App\Http\Livewire\Projects\Forms;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    public $title;
    public $start_date;
    public $due_date;
    public $note;

    protected $rules = [
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
        $data['title'] = $this->title;
        $data['start_date'] = $this->start_date;
        $data['due_date'] = $this->due_date;
        $data['note'] = $this->note;
        $data['add_by'] = Auth::user()->id;     

        $project = Project::create($data);
        if($project){
            return redirect()->route('projects.index')->with('status', 'Project created successfully.');  
        }
        return redirect()->route('projects.index')->with('delete', 'Project create faild, try again.');       
        
    }

    public function render()
    {
        return view('projects.components.create-form');
    }
}
