<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsDetails extends Model
{
    use HasFactory;
    protected $table = 'questions_details';
    public $timestamps = false;
    protected $fillable = ['question_id' , 'answer_serial' , 'answer_option'];
}
