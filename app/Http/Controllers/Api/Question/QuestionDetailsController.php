<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionsDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use function PHPUnit\Framework\isEmpty;

class QuestionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($question_id)
    {

        $question = Question::where('id', $question_id)->first();
        if (!$question)
            return Response::json(['message' => 'the question not found......'], 404);

        $questionDetails = QuestionsDetails::where('question_id', $question_id)->get();
        if (isEmpty($questionDetails))
            return Response::json(['message' => 'no details for this question'], 404);

        return Response::json($questionDetails, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->validate([
            'question_id' => ['required', 'exists:questions,id'],
            'answer_option' => ['required', 'string'],
        ]);
        $data['answer_serial'] = now();
        $question_details = QuestionsDetails::create($data);
        return Response::json($question_details, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $data =  $request->validate([
            'question_id' => ['sometimes' , 'required', 'exists:questions,id'],
            'answer_option' => ['sometimes' ,'required', 'string'],
        ]);
        $detail = QuestionsDetails::where('id' , $id)->first();
        if(!$detail)
        return Response::json([ 'message' => 'the detail not found'], 404);
        $detail->update($data);
        return Response::json($detail, 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Detail = QuestionsDetails::where('id' , $id)->first();
        if($Detail){
            $Detail->delete();
            return Response::json([
                'message' => 'the detail are deleted'
              ], 200);
        }
        return Response::json([
            'message' => 'the detail not found'
          ], 404);
    }
}
