<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillabe=['post_id','content'];

    public function posts(){
        return $this->belongsTo(Post::class);
    }
}
