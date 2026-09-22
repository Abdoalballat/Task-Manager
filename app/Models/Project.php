<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Project extends Model
{

    protected $fillable =[
        'title',
        'description',
        'project_status',
        
    ];

public function tasks() 
{
return $this->hasMany(Task::class);
}

}
