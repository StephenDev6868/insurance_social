<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookUser extends Model
{
    use HasFactory;
    protected $table = 'book_users';
    protected $fillable=[
        'book_id',
        'user_id',
        'quantity',
        'type_money',
        'status',
        'price',
    ];

    public function Course() : HasOne
    {
        return $this->hasOne(Book::class, 'book_id', 'id');
    }
}
