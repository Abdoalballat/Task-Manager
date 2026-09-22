<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class activity_logs extends Model
{
    protected $fillable=[
        'action',
        'description',
        'task_id',
        'user_id',
        'project_id'
    ];
    public function tasks()
{
return $this->belongsTo(Task::class);
}
}

