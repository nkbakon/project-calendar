<?php

namespace App\Http\Livewire\Todo\Forms;

use Livewire\Component;
use App\Models\Department;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class EditForm extends Component
{
    public $todo;
    public $all_departments;
    public $rows = [''];
    public $index;
    public $title;
    public $department; 
    public $status;  

    public function rules()
    {
        return [
            'department.*' => 'required',
            'title' => 'required',
            'status' => 'required',
        ];
    }

    public function mount($todo)
    {
        $this->all_departments = Department::all();
        $this->todo = $todo;
        $this->title = $todo->title;
        $this->status = $todo->status;
        $department_ids = json_decode($todo->department_ids);
        foreach($department_ids as $department_id) {
            $this->department[] = $department_id;
        }
        foreach($department_ids as $index => $department_id) {
            $this->rows[$index] = '';
        }
        
    }

    public function update()
    {
        $this->resetErrorBag('department');
        $validatedData = $this->validate($this->rules());
        $validatedData['edit_by'] = Auth::user()->id;

        $data['department_ids'] = json_encode($validatedData['department']);
        $data['edit_by'] = $validatedData['edit_by'];
        $data['title'] = $this->title;
        $data['status'] = $this->status;           
            
        $this->todo->update($data);
        return redirect()->route('todo.index')->with('success', 'To do updated successfully.');
        
    }

    public function render()
    {
        return view('todo.components.edit-form');
    }
}