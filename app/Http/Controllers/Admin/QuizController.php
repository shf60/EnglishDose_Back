<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\User;
use Carbon\Traits\Options;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(Auth $user)
    {
        // return view('admin.quiz.index');
        // $response = Gate::inspect('index',);
        // if($response->allow()){
            $quiz= Quiz::select(['id','question','tagify','userID'])->where('userID','=',$user::id())->with('answers')->get();
            return response()->json($quiz);            
        // }
        // else {
        //     echo $response->message();
        // }
            

    }
    public function create()
    {
        return view('admin.quiz.create');
    }
    public function store(Auth $auth,Request $request)
    {
        try{
            $quiz =Quiz::create([
                'question'=> $request->newQuestion['question'],
                'tagify'=>$request->newQuestion['tagify'],
                'userID'=> $auth::user()->id
            ]);
        $quiz->answers()->createMany($request->newQuestion['answers']);
        
        $quiz2= Quiz::select(['id','question','tagify'])->where('id','=',$quiz->id)->with('answers')->get();
            return response()->json($quiz2); 
        }
        catch(Exception $err){
            abort($err);
        }
    }
    public function update(Request $request,$id)
    {
        $question = Quiz::find($request->question_['id']);
        $response = Gate::inspect('quiz',$question);
        if($response->allowed()){
            $question->update(['question'=> $request->question_['question'],
            'tagify'=>$request->question_['tagify']]);
            $question->save();
            return $question;
        } 
        else {
            return $response->message();
        }
        
    }
    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        $response = Gate::inspect('quiz',$quiz);
        if ($response->allowed())
        {
        Quiz::destroy($id);
        }
        else{
            return $response->message();
        }
    }
}
