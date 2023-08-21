<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Models\Question;
use App\Models\QuestionsDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    public function index()
    {
        $question = Question::all();
        return Response::json($question, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $questionsData = $request->input('questions');
        //dd($questionsData);
        $data = [];
        DB::beginTransaction();
        foreach ($questionsData as $questionData) {
            $randomString = md5(rand());
            $question_serial = substr($randomString, 0, 10) . now();
            $questionData['question_serial'] =  $question_serial;
            $question =  Question::create($questionData);
            foreach($questionData['details'] as $detail){
              $newDetail = QuestionsDetails::create([
                   'question_id' => $question->id , 
                   'answer_serial' => 'indexserialcndj' ,
                   'answer_option' => $detail['answer_option']
              ]);
            }
            $data[] = $question;
            //details
        }
        DB::commit();
        return Response::json($data, 201);

       // return Response::json(['error' => 'failed to insert questions'], 500);

        // return Response::json(['error' => 'failed to insert questions'] , 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::where('id', $id)->first();
        if ($question) {
            return Response::json($question, 200);
        }
        return Response::json(['message' => 'the question not found to show'], 404);
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate($this->updateQuestionRule());
        $question  = Question::where('id', $id)->first();
        if ($question) {
            $question->update($data);
            return Response::json($question, 201);
        }
        return Response::json(['error' => ' the question not found'], 404);
    }


    public function destroy($id)
    {
        $question = Question::where('id', $id)->first();
        if ($question) {
            $question->delete();
            return Response::json(['message' => 'the question is deleted'], 200);
        }
        return Response::json(['message' => 'the question not found'], 404);
    }

    public function updateQuestionRule()
    {
        return [
            'survey_id' => 'sometimes|required|exists:surveys,id',
            'title' => 'sometimes|required|string|max:20|min:5',
            'question_type' => 'sometimes|required|numeric|between:1,5',
            'question_notes' => 'sometimes|required|string|max:150|min:5',
            'answer_option' => 'numeric|between:1,2'

        ];
    }
}
