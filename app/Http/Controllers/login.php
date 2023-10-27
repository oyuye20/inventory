<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class login extends Controller
{

    /* LOGIN */
    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'boolean'
        ]);

       /*  $rem = $validate['remember'] ?? false;
        unset($validate['remember']); */


        if(!Auth::attempt($validate))
        {
            return response(
                'Incorrect email or password please try again'
            , 422);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);

    }

    public function register (Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'image' => 'required'
        ]);


        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'image' => $data['image'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}
