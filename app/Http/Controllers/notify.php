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
        /* $inventory = inventory::with('product')->whereColumn('safety_stocks','>','stocks')->get(); */

        $expiring = inventory::with('product')
        ->where(DB::raw('DATEDIFF(expiration_date, CURDATE())'),'=', 90)->get();


        $expired = inventory::with('product')->whereDate('expiration_date', '<=', now())
        ->where(function($query)   {
            return $query
        ->where('stocks','>',0);
        })->paginate(10);


        $inventory = DB::table('inventories as i')
        ->join('product_infos as p','i.product_id','=','p.id')

        ->select('p.product_name','p.serial_number','p.manufacturer','p.size',
        DB::raw('SUM(i.stocks) as stocks1,SUM(i.safety_stocks) as safeStocks'))
        ->groupBy('i.product_id')

        ->havingRaw('safeStocks > stocks1 AND stocks1 > 0')
        ->get();




        $count = notification_table::where('isReaded', 0)->count();
        $notification = notification_table::where('isReaded', 0)->orderBy('created_at', 'DESC')->paginate(5);
        $user = User::where('role', '1')->get();

        $details = [];
        $checkInventory = '';
        $checkExpired = '';


        foreach($inventory as $i){
            $message = "The ".$i->product_name. " is on low stocks";
            $checkInventory = notification_table::where('message',$message)->exists();

            if(!$checkInventory){
                notification_table::create([
                    "message" => $message,
                ]);

                $details[] = "The ".$i->product_name. " is on low stocks ";
                Notification::send($user, new 
                inventory_notif(implode(",", $details)) );  
            } 
        }



        foreach($expired as $e){
            $message2 = "The ".$e->product->product_name. " is expired";
            $checkExpired = notification_table::where('message',$message2)->exists();

            if(!$checkExpired){
                notification_table::create([
                    "message" => $message2,
                ]);

                $details[] = "The ".$e->product->product_name. " is expired ";
                Notification::send($user, new 
                inventory_notif(implode(",", $details)) );
            }     
        }

        
    
        

        

        return response()->json([
            "count" => $count,
            "notification" => $notification
         ]);

    }



    public function readNotifications(){
        return notification_table::where('isReaded', '=', 0)->update(['isReaded' => 1]);

        /* if($notif)
        {
            return response()->json([
                'message' => 'read all notifications successfully'
            ]);
        }

        else {
            return response()->json([
                'message' => 'Product does not exists'
                
            ]);
        } */
    }


}
