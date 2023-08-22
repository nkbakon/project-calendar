<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use Carbon\Carbon;

class ProjectTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $projects = Project::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        foreach ($projects as $project) {
            $start = Carbon::parse(date("Y-m-d"));
            $due = Carbon::parse($project->due_date);
    
            $diff = $due->diffInDays($start);
            if ($diff < 0 || $due < $start) {
                $diff = 0;
            }
    
            $project->daysLeft = $diff;
        }
        
        return view('projects.components.project-table', [
            'projects' => $projects
        ]);
    }
}
