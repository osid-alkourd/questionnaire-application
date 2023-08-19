<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['survey_id' , 'question_serial' , 'title' , 'question_type', 
    'answer_option' , 'question_notes'];
}
