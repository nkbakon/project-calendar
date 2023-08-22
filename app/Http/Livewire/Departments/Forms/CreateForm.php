<?php

namespace App\Http\Livewire\Departments\Forms;

use Livewire\Component;
use App\Models\Department;

class CreateForm extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {   
        $data['name'] = $this->name;

        $department = Department::create($data);
        if($department){
            return redirect()->route('departments.index')->with('status', 'Department added successfully.');  
        }
        return redirect()->route('departments.index')->with('delete', 'Department adding faild, try again.');       
        
    }    

    public function render()
    {
        return view('departments.components.create-form');
    }

}
