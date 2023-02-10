<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyUser extends Model
{
    use HasFactory;
    protected $table ='survey_users';
    protected $fillable = ['survey_id','user_id', 'number_question_user_did'];
}
