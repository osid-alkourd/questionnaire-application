<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
    //    dd(request()->all());
        return [
           'questions' => 'required|array',
            'questions.*.survey_id' => 'required|exists:surveys,id',
            'questions.*.title' => 'required|string|max:20|min:5',
            'questions.*.question_type' => 'required|numeric|between:1,5',
            'questions.*.question_notes' => 'required|string|max:150|min:5',
            'questions.*.answer_option' => 'numeric|between:1,2'
            
        ];
    }
}
