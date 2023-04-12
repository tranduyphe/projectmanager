<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class ProjectUser extends Model
{
    use HasFactory;
    protected $table = 'project_users';
    protected $fillable = [         
        'project_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function details_project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
