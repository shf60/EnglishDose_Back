<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return view('about');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('admin')->namespace('Admin')->group(function(){
Route::get('quiz/create','QuizController@create');
Route::post('quiz/create','QuizController@store');
Route::get('quiz/index','QuizController@index');
Route::post('quiz/index','QuizController@store');
Route::put('about/{id}','AnswerController@update');

});
