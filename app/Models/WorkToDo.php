<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;

class WorkToDo extends Model
{
    use HasFactory;
    protected $table = 'work_todo';
    protected $fillable = [         
        'task_id',
        'title',
        'slug',
        'dealine'
    ];

    public function tasks()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }
}
