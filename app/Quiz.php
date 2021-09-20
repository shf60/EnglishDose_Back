<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //

    protected $table='quiz_pool';
    
    protected $fillable=['userID','question','tagify'];
    

    public function answers(){
        return $this->hasMany(Answer::class,'quizID','id')->
        select(['id','quizID','answer','correctAnswer']);
        
    }

    
}