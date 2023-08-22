<?php

namespace App\Http\Livewire\Todo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Todo;

class TodoTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $todos = Todo::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('todo.components.todo-table', [
            'todos' => $todos
        ]);
    }
}