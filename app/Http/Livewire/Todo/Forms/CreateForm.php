<?php

namespace App\Http\Livewire\Todo\Forms;

use Livewire\Component;
use App\Models\Department;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    public $index;
    public $rows = [''];
    public $departments = [];
    public $all_departments;
    public $title;
    public $x = 0;

    public function mount()
    {
        $departments = Department::all();
        $this->all_departments = $departments;        
        $this->departments[$this->x] = '';   
    }

    public function addRow()
    {
        $this->rows[] = '';
        $x = $this->x + 1;
        $this->departments[$x] = '';
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
            $this->departments[$index+1] = '';
            $this->render();
        }
    }

    protected $rules = [
        'departments' => 'required|array',
        'departments.*' => 'required',
        'title' => 'required',
    ];    

    public function store()
    {
        $this->resetErrorBag('departments');
        $this->departments = array_filter($this->departments);
        $data['department_ids'] = json_encode($this->departments);
        $data['title'] = $this->title;
        $data['add_by'] = Auth::user()->id;
        
        $departmentQuantities  = [];
               
        foreach($this->departments as $index => $department){

            $key = array_search($department, array_column($departmentQuantities, 'id'));

            if ($key !== false) {
                
            }
            else {
                $departmentQuantities[] = [
                    'id' => $department,
                ];
            }                
        }
        $data['department_ids'] = json_encode(array_column($departmentQuantities, 'id'));

        $todo = Todo::create($data);

        if($this->getErrorBag()->any()){
            return; // do not redirect if there are errors
        }

        if($todo){
            return redirect()->route('todo.index')->with('status', 'New To Do added successfully.');  
        }
        return redirect()->route('todo.index')->with('delete', 'To Do adding failed, try again.');       
        
    }

    public function render()
    {
        return view('todo.components.create-form');
    }
}