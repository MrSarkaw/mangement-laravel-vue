<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userTask extends Model
{
    use HasFactory;

    protected $fillable=["user_id","task_id","status"];

    public function task(){
        return $this->belongsTo(task::class,"task_id");
    }
    
}
