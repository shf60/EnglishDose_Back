<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quiz;
use Exception;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $quiz = Quiz::find($request->answer['quizID']);
            $response = Gate::inspect('quiz',$quiz);
            if ($response->allowed())
            {
                try{
           $answer= Answer::create($request->answer);
            return $answer->id;
            }
            catch(Exception $err){
                return $err;
            }}
     else{
            return $response->message();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $quiz = Quiz::find($request->quizID);
        $response = Gate::inspect('quiz',$quiz);
        if ($response->allowed())
        {
    try{
        $answer=Answer::find($request->id);
        $answer->answer=$request->answer;
        $answer->correctAnswer=$request->correctAnswer;
        $answer->save();
        return $request;
        }
    catch(Exception $err){
            return $err;
        }
    }
    else
    {
        return $response->message();
    }

            
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);
        $quiz = Quiz::find($answer->quizID);
        $response = Gate::inspect('quiz',$quiz);
        if ($response->allowed())
        {
        Answer::destroy($id);
        return $id;
        }
        else{
            return $response->message();
        }
    }
}
