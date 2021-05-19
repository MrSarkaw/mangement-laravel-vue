<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;


    protected $fillable = ["title", "description", "start_date", "end_date", "user_id"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks', 'task_id', 'user_id')
                    ->withPivot("status")->withTimestamps();
    }
}
