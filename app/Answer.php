<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
       protected $fillable =['quizID','answer','correctAnswer'];
    public function quiz(){
        return $this->belongsTo(Quiz::class,'quizID','id');
    }
    
}
