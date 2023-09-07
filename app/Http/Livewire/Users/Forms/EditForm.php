<?php

namespace App\Http\Livewire\Users\Forms;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;

class EditForm extends Component
{
    public $user;
    public $departments;

    public function rules()
    {
        return [
            'user.fname' => 'required',
            'user.lname' => 'required',
            'user.username' => 'required|unique:users,username,' . $this->user->id,
            'user.email' => 'required|unique:users,email,' . $this->user->id,
            'user.type' => 'required',
            'user.department_id' => '',
            'user.status' => 'required',
        ];
    }

    public function mount()
    {
        $this->departments = Department::all();
        $this->department = '';
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $data['fname'] = $validatedData['user']['fname'];
        $data['lname'] = $validatedData['user']['lname'];
        $data['username'] = $validatedData['user']['username'];
        $data['email'] = $validatedData['user']['email'];
        $data['type'] = $validatedData['user']['type'];
        if($validatedData['user']['department_id'] == "None"){
            $data['department_id'] = null;
        }
        else{
            $data['department_id'] = $validatedData['user']['department_id'];
        }
        $data['status'] = $validatedData['user']['status'];
        $data['name'] = $validatedData['user']['fname'] . ' ' . $validatedData['user']['lname'];
        
        $this->user->update($data);        
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function render()
    {
        return view('users.components.edit-form');
    }
}

