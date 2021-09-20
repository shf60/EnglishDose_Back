<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Answer;
use App\User;
use Illuminate\Auth\Access\Response;

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
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/index','Admin\QuizController@index');
    Route::post('/create','Admin\QuizController@store');
    Route::post('/createAnswer','Admin\AnswerController@store');
    Route::put('/updateQuestion/{id}','Admin\QuizController@update');
    Route::put('/updateAnswer/{id}','Admin\AnswerController@update');    
    Route::delete('/deleteAnswer/{id}','Admin\AnswerController@destroy');
    Route::delete('/deleteQuestion/{id}','Admin\QuizController@destroy');
    Route::get('/me', 'UserController@currenUser');
});



Route::post('/login','UserController@login')->middleware('throttle:30,1');
Route::post('/register','UserController@register')->middleware('throttle:20,1');
Route::put('/updateUser/{id}','UserController@update')->middleware('throttle:20,1');


