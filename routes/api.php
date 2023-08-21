<?php

use App\Http\Controllers\Api\Tenant\TenantController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Survey\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Question\QuestionController;
use App\Http\Controllers\Api\Question\QuestionDetailsController;
use App\Http\Controllers\Api\Response\ResponseControlller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'prefix' => '/tenant',
    'as' => 'tenant.',
], function () {
    Route::post('/login', [TenantController::class, 'login'])->name('login.store');
    Route::post('/register', [TenantController::class, 'store_tenant'])->name('register');
    Route::delete('/logout', [TenantController::class, 'logout'])->name('logout');
    Route::get('/test', [TenantController::class, 'test'])->name('test')->middleware('auth:tenant');
    // Route::post('/logout', 'logout')->name('logout');
});

// user group
Route::group([
    'prefix' => '/user',
    'as' => 'user.',
], function () {
    Route::post('/login', [UserController::class, 'login'])->name('login.store');
    Route::post('/register', [UserController::class, 'store_user'])->name('register.store');
    Route::delete('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:user');
// Route::post('/logout', 'logout')->name('logout');
});

// surveys
Route::apiResource('surveys', SurveyController::class)->middleware('auth:user');
Route::get('surveys/{id}/showQuestions' , [SurveyController::class , 'show_survey_question'])->middleware('auth:user');
// questions
Route::apiResource('questions', QuestionController::class)->middleware('auth:user');


Route::group([
    'middleware' => ['auth:user'] ,
    'prefix' => '/details/question',
  //  'as' => 'question.details',
], function () {
    Route::get('/{question_id}',  [QuestionDetailsController::class, 'index']);
    Route::post('/' , [QuestionDetailsController::class, 'store']);
    Route::put('/{details_id}' , [QuestionDetailsController::class, 'update']);
    Route::get('/{details_id}' , [QuestionDetailsController::class, 'show']);
    Route::delete('/{details_id}' , [QuestionDetailsController::class , 'destroy']);
});



Route::group([
    'middleware' => ['auth:user'] ,
    'prefix' => '/responses',
    //'as' => 'response.',
], function () {
    Route::get('/',  [ResponseControlller::class, 'index']);
    Route::post('/' , [ResponseControlller::class, 'store']);
    Route::put('/{id}' , [ResponseControlller::class, 'update']);
    Route::get('/{id}' , [ResponseControlller::class, 'show']);
    Route::delete('/{id}' , [ResponseControlller::class , 'destroy']);
});

