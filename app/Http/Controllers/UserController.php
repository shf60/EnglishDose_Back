<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function currenUser(Auth $auth){
        return $auth::user();
    }

    public function register(Request $request){
        $fields=$request->validate([
            'name'=> 'required|string',
            'userName'=>'required|string|unique:users,userName',
            'password'=>'required|string|confirmed',
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

        return response($response,201);
    }

    public function update(Request $request,$id){
        $fields=$request->validate([
            'name'=> 'string',
            'userName'=>'string|unique:users,userName',
            'password'=>'string|confirmed',
            'email'=>'string|unique:users,email',
            'phoneNumber'=>'string|unique:users,phoneNumber',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        
        $user = User::find($id);

        if ($key= array_search('password',$fields)){
            $user->password=bcrypt($fields['password']);
            unset($fields[$key]);
        }
        $user->update($fields);
        $user->save();
        return $fields;
    }
}

