<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class login extends Authenticatable
{
    use HasUuids ;
    protected $table ='login';
    protected $keyType = 'string';
    public $incrementing = false;
    protected  $fillable =[
        'username',
        'role',
        'password',
        'email',
        'status',
        'otpcode',
        'otp_expires_at',

    ];

    public function tasks()
    {
        return $this->hasMany(Task::class,'user_id', 'id');
    }
    public function activity_logs()
    {
        return $this->hasMany(activity_logs::class);
    }
}
