<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

   
    protected $fillable = [
        'name',
        'email',
        'password',
        'path',
        "user_id",
        "isAdmin"
    ];

  
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function task()
    {
        $this->hasMany(task::class, "user_id");
    }

    public function tasks()
    {
        return $this->belongsToMany(task::class, "user_tasks", "user_id", "task_id")
            ->withPivot("status")->withTimestamps();;
    }

    // check for admin permission
    public function IsAdmin(){
        if($this->isAdmin==1){
            return true;
        }
        return false;
    }

    // hash for password
    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = Hash::make($value);
    }
}
