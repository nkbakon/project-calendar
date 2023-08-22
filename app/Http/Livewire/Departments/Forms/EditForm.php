<?php

namespace App\Http\Livewire\Departments\Forms;

use Livewire\Component;
use App\Models\Department;

class EditForm extends Component
{
    public $department;

    public function rules()
    {
        return [
            'department.name' => 'required',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $this->validate($this->rules());

        $editDepartment = $this->validate();

        $this->department->update($editDepartment);
        
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function render()
    {
        return view('departments.components.edit-form');
    }
}


