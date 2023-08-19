<?php

namespace App\Http\Controllers\Api\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Response;
use Illuminate\Support\Facades\Response as FacadesResponse;

class ResponseControlller extends Controller
{
    

    public function index()
    {
        $response = Response::leftJoin('surveys' , 'responses.survey_id' , '=' , 'surveys.id')
                            ->leftJoin('questions' , 'responses.question_id' , '=' , 'questions.id')
                            ->select('responses.*' , 'surveys.survey_caption' , 'questions.title')
                            ->get();
        return FacadesResponse::json($response , 200);                    

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $data = $request->all();
        return $data['survey_id'][0];
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
