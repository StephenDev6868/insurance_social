<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    protected $table = 'notifies';
    protected $fillable = [
        'title',
        'description',
    ];
    public function notify_user(){
        return $this->hasMany('App\Models\NotifyUser', 'notify_id', 'id');
    }
}
