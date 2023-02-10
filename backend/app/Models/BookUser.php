<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookUser extends Model
{
    use HasFactory;
    protected $table = 'book_users';
    protected $fillable=[
        'book_id',
        'user_id',
        'quantity',
        'type_money',
        'status'
    ];
}
