<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionsDetails;
class Question extends Model
{
    use HasFactory;
    protected $fillable = ['survey_id' , 'question_serial' , 'title' , 'question_type', 
    'answer_option' , 'question_notes'];
    protected $casts = [
        'question_type' => 'integer',
        'answer_option' => 'integer'
    ];
    public function details()
    {
      return $this->hasMany(QuestionsDetails::class);
    }
}
