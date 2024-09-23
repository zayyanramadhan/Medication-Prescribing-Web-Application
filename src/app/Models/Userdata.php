<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Userdata extends Authenticatable
{
    use Notifiable;
    protected $table = 'userdata';
    protected $fillable = [
        'name',
        'username',
        'level',
        'password',
    ];

    // Optional: If you want to hash the password automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->password) {
                $model->password = bcrypt($model->password);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('password') && $model->password) {
                $model->password = bcrypt($model->password);
            }
        });
    }
}
