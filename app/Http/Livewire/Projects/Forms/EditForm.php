<?php

namespace App\Http\Livewire\Projects\Forms;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditForm extends Component
{
    use WithFileUploads;

    public $project;
    public $all_users;
    public $rows = [''];
    public $index;
    public $user;
    public $original_names = [];
    public $documents = [];
    public $updatedocuments = []; 

    public function rules()
    {
        return [
            'title' => 'required',
            'start_date' => 'required|date|after_or_equal:' . $this->project->start_date,
            'due_date' => 'required|after_or_equal:start_date',
            'user.*' => 'required',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function mount($project)
    {
        $this->all_users = User::where('status', 'Active')->get();
        $this->project = $project;
        $this->documents = $project->documents;
        $this->original_names = $project->original_names;
        $this->title = $project->title;
        $this->start_date = $project->start_date;
        $this->due_date = $project->due_date;
        $this->note = $project->note;
        if($project->user_ids != null)
        {
            $user_ids = json_decode($project->user_ids);
            foreach($user_ids as $user_id) {
                $this->user[] = $user_id;
            }
            foreach($user_ids as $index => $user_id) {
                $this->rows[$index] = '';
            }
        }
        
    }

    public function removeDocs()
    {
        $documents = json_decode($this->documents);
        foreach ($documents as $document) {
            Storage::disk('public')->delete($document);
        }
        $data['original_names'] = '';
        $data['documents'] = '';
        $this->project->update($data);
        return redirect()->route('projects.edit', $this->project->id);
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $this->resetErrorBag('user');
        $data['title'] = $this->title;
        $data['start_date'] = $this->start_date;
        $data['due_date'] = $this->due_date;
        $data['note'] = $this->note;
        $data['edit_by'] = Auth::user()->id;

        if($this->documents == ''){
            foreach ($this->updatedocuments as $document) {
                $originalFileName = $document->getClientOriginalName();
                $originalNames[] = $originalFileName;

                $urls[] = $document->store('documents', 'public');
            }
            $data['documents'] = json_encode($urls);
            $data['original_names'] = json_encode($originalNames);
        }

        if($this->project->user_ids != null)
        {
            $data['user_ids'] = json_encode($validatedData['user']);
        }        
        
        $this->project->update($data);        
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function render()
    {
        return view('projects.components.edit-form');
    }
}

