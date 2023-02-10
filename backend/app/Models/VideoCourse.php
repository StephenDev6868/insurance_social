<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCourse extends Model
{
    use HasFactory;
    protected $table = 'video_courses';
    protected $fillable=[
        'title',
        'video',
        'check',
        'course_id',
    ];
}
