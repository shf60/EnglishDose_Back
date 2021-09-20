<?php

namespace App\Policies;

use App\User;
use App\Quiz;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        //
    }
    public function quiz(User $user,Quiz $question){
        return $user->id===$question->userID
        ? Response::allow('Allowed to Update')
        : Response::deny('You do not own this quiz',401);
    }
}