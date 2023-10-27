<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\notification_table;
use Illuminate\Support\Facades\DB;

class notify extends Controller
{
    public function checkStocks(){
        $inventory = inventory::with('product')->whereColumn('stocks', '<', 'safety_stocks')->get();
        $count = notification_table::where('isReaded', 0)->count();
        $notification = notification_table::where('isReaded', 0)->get();


        foreach($inventory as $i){
            $message = "The ".$i->product->product_name. " is on low stocks";
            $check = notification_table::where('message',$message)->exists();

            if(!$check){
                notification_table::create([
                    "message" => $message,
                ]);
            }     
        }

        return response()->json([
            "count" => $count,
            "notification" => $notification
         ]);

    }

   





}
