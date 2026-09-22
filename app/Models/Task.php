<?php

namespace App\Models;

use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Observers\task_observer;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
class Task extends Model
{
    protected $fillable =[
    'id',
    'status',
    'description',
    'title',
    'project_id',
    'priority',
    'deadline',
    'user_id',
    'recurrence_pattern',
    'is_recurring',

    ];

public function project() 
{
return $this->BelongsTo(Project::class);
}
public function login()
{
return $this->BelongsTo(login::class);
}
public function activity_logs()
{
return $this->hasMany(activity_logs::class);
}

}

