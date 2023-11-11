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

        


    
        /* $rem = $validate['remember'] ?? false;
        unset($validate['remember']); */


        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'isActivated' => $request = 1,
        );


        if(Auth::attempt($userdata))
        {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token
            ]);       
        }
        

        else {
            return response(
                'Incorrect email or password please try again'
            , 422);
        }
    }



    public function updateProfile(Request $request,$id){
        $r = json_decode($request->input("user_data"),true);

        $user = User::find($id);

        if($request->hasFile('image')){
            unlink(public_path('storage/images/'.$user->image));

            $image = $request->file('image');
            $ext = $image->extension();
            $file = time().'.'.$ext;
            $image->storeAs('public/images', $file);
            $user->image = $file;
            $user->save();
        }


        $user->username = $r['username'];
        $user->save();


    }



    public function staffLists(){
        return User::where('role', '0')->paginate(5);
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
