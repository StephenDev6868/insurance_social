<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected  $table= 'books';
    protected $fillable=[
        'title',
        'description',
        'admin_id',
        'admin_name',
        'sold',
        'image',
        'price',
        'coin',
        'price_reduce',
        'coin_reduce',
        'discount',
        'category_id',
        'category_name',
        'size',
        'page',
        'cover_type',
        'publish_year',
        'publish_company',
        'type'
    ];
    public function bookChapter(){
        return $this->hasMany('App\Models\BookChapter','book_id','id');
    }
}
