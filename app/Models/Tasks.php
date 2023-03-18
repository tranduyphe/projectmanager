<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
