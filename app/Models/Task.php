<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'start_date',
        'due_date',
        'status',
        'note',
        'add_by',
        'edit_by',
        'created_at',
        'updated_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function addby()
    {
        return $this->belongsTo(User::class, 'add_by', 'id');
    }

    public function editby()
    {
        if (!empty($this->edit_by)){
            return $this->belongsTo(User::class, 'edit_by', 'id');
        }
        
        return $this->belongsTo(User::class, 'add_by', 'id');
    }

    public static function search($search)
    {
        return empty($search)
        ? static::query()
        : static::query()->where('id', 'like', '%' . $search . '%')
            ->orWhere('title', 'like', '%' . $search . '%')
            ->orWhere('due_date', 'like', '%' . $search . '%');
    }

    public function getStatusColorAttribute()
    {
        return [
            'Not Started' => 'red',
            'In Progress' => 'yellow',
            'Waiting Approval' => 'blue',
            'Approved' => 'green',
        ][$this->status] ?? 'cool-gray';
    }
}
