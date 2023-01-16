<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyUser extends Model
{
    use HasFactory;
    protected $table='notify_users';
    protected $fillable=[
        'notify_id',
        'user_id',
        'check'
    ];
}
