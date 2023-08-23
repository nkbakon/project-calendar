<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class WorkerTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $user = Auth::user()->id;
        $query = Task::query();

        if ($user) {
            $query->where('user_id', $user);
        }

        $tasks = $query->where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhereHas('project', function($query) {
                    $query->where('title', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('user', function($query) {
                    $query->where('username', 'like', '%' . $this->search . '%');
                })
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhere('due_date', 'like', '%' . $this->search . '%')
                ->orWhere('title', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('tasks.components.worker-table', [
            'tasks' => $tasks
        ]);
    }
}
