<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
        */
    protected $fillable = ['article'];

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
