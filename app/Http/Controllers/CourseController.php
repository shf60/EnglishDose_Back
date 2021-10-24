<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function create(Request $request)
    {
        try {
            $response = Gate::inspect('permission', Course::class);
            if ($response->allowed()) {
                $fields = $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'classSize' => 'string',
                    'numberOfSessions' => 'integer'
                ]);
                $course = Course::create($fields);
                return $course;
            } else {
                return $response->message();
            }
        } catch (Exception $err) {
            return $err;
        }
    }
    public function update(Request $request, $id)
    {
        $response = Gate::inspect('permission', Course::class);
        if ($response->allowed()) {
            $fields = $request->validate([
                'name' => 'string',
                'description' => 'string',
                'classSize' => 'string',
                'numberOfSessions' => 'integer'
            ]);
            $course = Course::find($id);
            $course->update($fields);
            $course->save();
            return $course;
        } else {
            return $response->message();
        }
    }
    public function delete($id)
    {
        $course = new Course;
        $response = Gate::inspect('permission', $course);
        if ($response->allowed()) {
            $msg = 'deleted';
            $course::find($id)
                ? $course->destroy($id)
                : $msg = 'not exist!';
            return $msg;
        } else {
            return $response->message();
        }
    }
    public function index()
    {
        return Course::all();
    }
}
