<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Project;
use App\Models\DepartmentUser;
use App\Models\ProjectUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * List projetcs.
     *
     * @var $user_id
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    /**
     * List projetcs.
     *
     * @var $user_id
     */
    public function detail_user_department()
    {
        return $this->hasOne(DepartmentUser::class, 'user_id');
    }

    /**
     * List projetcs user.
     *
     * @var $user_id
     */
    public function projects_user()
    {
        return $this->hasMany(ProjectUser::class, 'user_id');
    }
}      
