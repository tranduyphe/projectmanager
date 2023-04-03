<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Card;
use App\Models\Project;
use App\Models\WorkToDo;

class Tasks extends Model
{
    use HasFactory;
    protected $fillable = [         
        'project_id',
        'card_id',
        'department_id',
        'list_user_ids',
        'slug',
        'description',
        'title',
        'dealine'
    ];

    // public function card()
    // {
    //     return $this->belongsTo(Card::class, 'card_id');
    // }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * 
     */
     /**
     * List projetcs.
     *
     * @var $user_id
     */
    public function worktodo()
    {
        return $this->hasMany(WorkToDo::class, 'task_id');
    }
}
