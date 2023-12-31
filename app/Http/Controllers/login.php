<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class login extends Controller
{

    /* LOGIN */
    public function login(Request $request)
    {
        /* $validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'boolean'
        ]); */

        
    
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


    public function editAccount($id){
        return User::find($id);
    }



    public function editList(Request $request, $id){
        $r = json_decode($request->input("accData"),true);

        $acc = User::find($id);

        if($request->hasFile('image')){
            unlink(public_path('storage/images/'.$acc->image));

            $image = $request->file('image');
            $ext = $image->extension();
            $file = time().'.'.$ext;
            $image->storeAs('public/images', $file);
            $acc->image = $file;
            $acc->save();
        }


        $acc->update([
            'username'=>$r['username'],
            'email'=>$r['email'],
            'isActivated'=>$r['isActivated'],
        ]); 


        /* $cat = category::find($id);
        

        $cat->update([
            'category'=>ucfirst($r['category']),
            'description'=>ucfirst($r['description']),
        ]); */
    }




    public function register (Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'image' => 'required',
        ]);



        if($request->hasFile('image')){
            $image = $request->file('image');
            $ext = $image->extension();
            $file = time().'.'.$ext;
            $image->storeAs('public/images', $file);
        }


        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'isActivated' => 1,
            'image' => $data['image'],
            'password' => bcrypt($data['password']),
            'image' => $file,
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
