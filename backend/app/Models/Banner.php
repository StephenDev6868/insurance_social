<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'banners';
    protected $fillable = [
        'banner_image',
        'book_image',
        'book_text',
        'course_image',
        'course_text',
        'survey_image',
        'survey_text',
        'register_image',
        'register_text',
        'splash_image'
    ];
}
