<?php

namespace App\Policies;

use App\Course;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    use HandlesAuthorization;

    public function permission(User $user)
    {
        return $user->role == 'admin'
        ? Response::allow('Allowed to create',201) 
        : Response::deny('You have no access',401);
    }
}
