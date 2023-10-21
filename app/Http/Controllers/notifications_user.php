<?php

namespace App\Http\Controllers;
use App\Notifications\inv_notif;
use App\Models\User;
use App\Models\inventory;
use Illuminate\Support\Facades\Notification;
/* use Illuminate\Support\Facades\DB; */


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class notifications_user extends Controller
{
    public function notify(){

        $users = User::all();

        $safe_stocks = 30;

        $crit = inventory::with('product')->where('stocks', '<', $safe_stocks)->get();

        foreach($crit as $c){

        }

        $message = "the ".$c->product->product_name." is expired";
        

        Notification::send($users, new inv_notif($message));
    }


    public function indexNotif(){

        return User::find(1)->notifications;
 
    }
}
