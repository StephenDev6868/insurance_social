<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  use HasFactory;
  protected $table = 'courses';
  protected $fillable = [
    'title',
    'description',
    'sold',
    'image',
    'admin_id',
    'admin_name',
    'discount',
    'price',
    'coin',
    'price_reduce',
    'coin_reduce',
    'view',
    'type',
    'category_id',
    'opening_date',
    'application',
    'password',
    'link'
  ];
  public function courseVideo(){
    return $this->hasMany('App\Models\VideoCourse', 'course_id', 'id');
  }
}