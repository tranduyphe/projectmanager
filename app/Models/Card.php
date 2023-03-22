<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;
use App\Models\Project;

class Card extends Model
{
    use HasFactory;

    // public function tasks()
    // {
    //     return $this->hasMany(Tasks::class, 'card_id');
    // }
}
