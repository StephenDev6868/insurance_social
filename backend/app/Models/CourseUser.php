<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CourseUser extends Model
{
    use HasFactory;
    protected $table = 'course_users';
    protected $fillable=[
        'course_id',
        'user_id',
        'quantity',
        'type_money',
        'status',
        'price',
    ];

    public function Course() : HasOne
    {
        return $this->hasOne(Course::class, 'course_id', 'id');
    }
}
