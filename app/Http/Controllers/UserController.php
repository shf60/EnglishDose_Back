<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'userName' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('userName', $request->userName)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'UserName' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('token');

        return ['token' => $token->plainTextToken];
        
        // $user->tokens()->delete();
    }
    public function currentUser(Auth $auth){
        return $auth::user();
    }

    public function register(Request $request){
        $fields=$request->validate([
            'name'=> 'required|string',
            'userName'=>'required|string|unique:users,userName',
            'password'=>'required|string|confirmed|min:6',
            'email'=>'required|string|unique:users,email',
            'phoneNumber'=>'required|string|unique:users,phoneNumber',
        ]);
        $user=User::create([
            'name'=>$fields['name'],
            'userName'=>$fields['userName'],
            'email'=>$fields['email'],
            'phoneNumber'=>$fields['phoneNumber'],
            'password'=> bcrypt($fields['password'])
        ]);
        $token=$user->createToken('token')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        event(new Registered($user));
        return response($response,201);
    }

    public function update(Request $request,$id){
        $user=User::find($id);
        $response=Gate::inspect('update',$user);
        if($response->allowed()){
        $fields=$request->validate([
            'name'=> 'string',
            'password'=>'string|confirmed|min:6',
            'email'=>'string|unique:users,email',
            'phoneNumber'=>'string|unique:users,phoneNumber',
            'profilePhoto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'birthDate'=>'date',
        ]);
        if ($request->hasFile('profilePhoto')) {
            $image= $request->file('profilePhoto');
            $extension = $image->getClientOriginalExtension();
            $imageName = time().'.'.$extension;
            $image->move(public_path('uploads/profilePhoto/'), $imageName);
            $user->profilePhoto='uploads/profilePhoto/'.$imageName;
            unset($fields['profilePhoto']);
        }
        if ($request->has('password')){
            $user->password=Hash::make($request->password);
            unset($fields['password']);
        }
        $user->update($fields);
        $user->save();
        return $fields;
    } 
     else {
        return $response->message();
    }
    }  
}

