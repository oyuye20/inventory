<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\notification_table;
use App\Models\User;
use App\Notifications\inventory_notif;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class notify extends Controller
{
    public function checkStocks(){
        $inventory = inventory::with('product')->whereColumn('safety_stocks','>','stocks')->get();
        $count = notification_table::where('isReaded', 0)->count();
        $notification = notification_table::where('isReaded', 0)->orderBy('created_at', 'DESC')->paginate(5);
        $user = User::where('role', '1')->get();

        
        foreach($inventory as $i){
            $message = "The ".$i->product->product_name. " is on low stocks";
            $check = notification_table::where('message',$message)->exists();

            
            if(!$check){
                notification_table::create([
                    "message" => $message,
                ]);

                $details[] = "The ".$i->product->product_name. " is on low stocks ";

            }     


            if(!$check){
                Notification::send($user, new 
                inventory_notif(implode(",", $details)) );
                echo 'success';
            }
        }

     


        return response()->json([
            "count" => $count,
            "notification" => $notification
         ]);

    }




}
