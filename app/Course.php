<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
   protected $fillable=['name','description','numberOfSessions','classSize','platform','price','photo'];
}