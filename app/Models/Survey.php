<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $fillable = ['survey_caption' , 'status' , 'created_by' , 'expire_at'];

    public function questions()
    {
      return $this->hasMany(Question::class);
    }
}
