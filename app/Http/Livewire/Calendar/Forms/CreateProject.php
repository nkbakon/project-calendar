<?php

namespace App\Http\Livewire\Calendar\Forms;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateProject extends Component
{
    use WithFileUploads;

    public $selectedDate;
    public $title;
    public $start_date;
    public $due_date;
    public $note;
    public $documents = [];
    public $index;
    public $rows = [''];
    public $users = [];
    public $all_users;
    public $x = 0;

    public function mount($selectedDate)
    {
        $this->start_date = $selectedDate;
        $users = User::where('status', 'Active')->get();
        $this->all_users = $users;        
        $this->users[$this->x] = '';   
    }

    public function addRow()
    {
        $this->rows[] = '';
        $x = $this->x + 1;
        $this->users[$x] = '';
        $this->x = $x;
        $this->render();
    }

    public function removeRow($index)
    {
        if($index != 0)
        {
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
            $index = $index - 1;
            $x = $this->x - 1;
            $this->x = $x;
            $this->users[$index+1] = '';
            $this->render();
        }
    }

    protected $rules = [
        'title' => 'required',
        'start_date' => 'required|after_or_equal:today',
        'due_date' => 'required|after_or_equal:start_date',
        'users' => 'required|array',
        'users.*' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {   
        $validatedData = $this->validate($this->rules);
        $this->resetErrorBag('users');
        $this->users = array_filter($this->users);
        $data['user_ids'] = json_encode($this->users);
        $data['title'] = $this->title;
        $data['start_date'] = $this->start_date;
        $data['due_date'] = $this->due_date;
        $data['note'] = $this->note;
        $data['add_by'] = Auth::user()->id;

        $originalNames = [];
        $urls = [];

        foreach ($this->documents as $document) {
            $originalFileName = $document->getClientOriginalName();
            $originalNames[] = $originalFileName;

            $urls[] = $document->store('documents', 'public');
        }

        $data['documents'] = json_encode($urls);
        $data['original_names'] = json_encode($originalNames);
        
        $userQuantities  = [];
               
        foreach($this->users as $index => $user){

            $key = array_search($user, array_column($userQuantities, 'id'));

            if ($key !== false) {
                
            }
            else {
                $userQuantities[] = [
                    'id' => $user,
                ];
            }                
        }
        $data['user_ids'] = json_encode(array_column($userQuantities, 'id'));

        $project = Project::create($data);

        if($this->getErrorBag()->any()){
            return; // do not redirect if there are errors
        }

        if($project){
            return redirect()->route('projects.index')->with('status', 'Project created successfully.');  
        }
        return redirect()->route('projects.index')->with('delete', 'Project create faild, try again.');       
        
    }

    public function render()
    {
        return view('calendar.components.create-project');
    }
}

