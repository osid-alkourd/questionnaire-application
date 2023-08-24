<?php

namespace App\Http\Controllers\Api\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSurveyRequest;
use App\Models\Question;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\QuestionsDetails;
use Illuminate\Support\Facades\DB;
class SurveyController extends Controller
{
  //$user_id = Auth::guard('user')->user()->id;

  public function index()
  {
    $surveys = Survey::all();
    return Response::json($surveys, 200);
  }

  public function store(StoreSurveyRequest $request)
  {
    $data = $request->all();
    $user_id = $this->currentUser()->id;
    $data['created_by'] = $user_id;
    //$data['expire_at'] = Carbon::createFromFormat('m/d/Y', $request->expire_at)->format('Y-m-d');
    $data['expire_at'] = Carbon::parse($request->expire_at)->toDateString();
    $survey = Survey::create($data);
    return Response::json($survey, 201);
  }

  public function currentUser()
  {
    return $user = Auth::guard('user')->user();
  }

  public function update(Request $request, $id)
  {
    $request->validate($this->updateSurveyRule());
    $data = $request->all();
    $user_id = $this->currentUser()->id;
    $data['created_by'] = $user_id;
    if ($request->expire_at) {
      $data['expire_at'] = Carbon::createFromFormat('m/d/Y', $request->expire_at)->format('Y-m-d');
    }
    $survey = Survey::where('id', $id)->first();
    if ($survey) {
      $survey->update($data);
      return Response::json($survey, 201);
    }
  }

  public function destroy($id)
  {
    $survey = Survey::where('id', $id)->first();
    if ($survey) {
      $survey->delete();
      return Response::json([
        'message' => 'the survey are deleted'
      ], 200);
    }
    return Response::json([
      'message' => 'the survey not exist'
    ], 404);
  }

  public function show($id)
  {
    $surveys = Survey::with('questions.details')->where('id' , $id)->first();
    //dd($questions);
    return Response::json($surveys , 200);
    //the code without relation
    // $survey = Survey::where('id' , $id)->first();
    // $questions = Question::where('survey_id' , $id)->get();
    // foreach($questions as $question){
    //   $details = QuestionsDetails::where('question_id' , $question->id)->get();
    //   $question->details = $details;
    // }
    // $survey->questions = $questions;
    // return Response::json($survey , 200);
  }

  public function show_survey_question($survey_id)
  {
    $questions = Question::with('details')->where('survey_id' , $survey_id)->get();
    //dd($questions);
    return Response::json($questions , 200);
    
  //   $questions = DB::table('questions')->where('survey_id', $survey_id)->get();
  //   foreach ($questions as $question) {
  //     $questionDetails = DB::table('questions_details')->where('question_id', $question->id)->get();
  //     $question->details = $questionDetails;
  // }
  //    return Response::json($questions, 200);

   
  }

  public function updateSurveyRule()
  {
    return [
      'survey_caption' => 'sometimes|required',
      'expire_at' => 'sometimes|required|date',
      'status' => 'sometimes|required|numeric|between:1,3'
    ];
  }
}
