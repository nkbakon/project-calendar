<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todos';

    protected $fillable = [
        'title',
        'status',
        'department_ids',
        'add_by',
        'edit_by',
        'created_at',
        'updated_at',
    ];

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
            ->orWhereHas('addby', function($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%');
            })
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhere('created_at', 'like', '%' . $search . '%')
            ->orWhere('title', 'like', '%' . $search . '%');
    }

    public function getStatusColorAttribute()
    {
        return [
            'Active' => 'yellow',
            'Done' => 'green',
        ][$this->status] ?? 'cool-gray';
    }

}
