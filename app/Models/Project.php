<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Card;
use App\Models\Tasks;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',         
        'title',
        'slug',
        'description',
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function tasks()
    // {
    //     return $this->belongsTo(Tasks::class, 'project_id');
    // }
    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'project_id');
    }
}
