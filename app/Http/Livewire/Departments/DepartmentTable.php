<?php

namespace App\Http\Livewire\Departments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Department;

class DepartmentTable extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $departments = Department::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('departments.components.department-table', [
            'departments' => $departments
        ]);
    }
}