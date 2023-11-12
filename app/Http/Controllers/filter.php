<?php

namespace App\Http\Controllers;
use App\Models\inventory;
use App\Models\customer_orders;
use Illuminate\Http\Request;
use App\Models\product_info;
use App\Models\transactions;
use League\CommonMark\Node\Query\AndExpr;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class filter extends Controller
{

    /* SEARCH BOX FOR PRODUCT NAME */
    public function search($data){
        return product_info::with('category')->where('isArchived', '=', 0)
        ->where(function($query) use($data)  {
              return $query
                ->where('manufacturer','LIKE','%'.$data.'%')
                ->orWhere('product_name','LIKE','%'.$data.'%');
        })
        ->paginate(5); 
    }  



    public function searchInventory($data){
      return inventory::with('product')->where('stocks','>','0')->whereHas('product', function ($query) use($data) {
        $query->where('product_name','LIKE','%'.$data.'%')
              ->orWhere('manufacturer','LIKE','%'.$data.'%')
              ->orWhere('serial_number','LIKE','%'.$data.'%');
      })->orderBy('created_at','ASC')->groupBy('product_id')->paginate(5);
      
      
      /* return inventory::with('product')->whereHas('product', function ($query) use($data) {
        $query->where('product_name','LIKE','%'.$data.'%');
      })->paginate(5); */
    }


    

    public function searchInventoryLists($data){
      return inventory::with('product')->where('stocks','>','0')->whereHas('product', function ($query) use($data) {
        $query->where('product_name','LIKE','%'.$data.'%')
          ->orWhere('manufacturer','LIKE','%'.$data.'%')
          ->orWhere('serial_number','LIKE','%'.$data.'%');
      })->paginate(5);
    }





    public function searchSold(){

    }

    public function searchCritical($data){
      return inventory::with('product')->whereHas('product', function ($query) use($data) {
        $query->whereColumn('safety_stocks','>','stocks')->where(function($query) use($data) {
          $query->where('product_name','LIKE','%'.$data.'%');
        });
      }) ->paginate(5);

    }


    

    public function searchExpired(){

    }

    public function searchOrder(){

    }


    public function searchSoldOutItems($data){
      
    }




    public function filterDaily($date){

      $start = $date.' 00:00:00';
      $end = $date.' 23:59:59';

      return DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price',
        DB::raw('DATE_FORMAT(transactions.purchase_date, "%m/%d/%y %r") AS purchase_date'),
        DB::raw('sum(customer_orders.quantity) as total_quantity'),
        DB::raw('sum(customer_orders.total) as total_sold'))

      
        ->whereBetween('transactions.purchase_date',[$start, $end])
        ->groupBy('customer_orders.product_name')
        ->paginate(5);

    }








    public function filterMonth($date){


        /* return $customer = DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price',
        'transactions.purchase_date',DB::raw('MONTHNAME(transactions.purchase_date) as Month'),
        DB::raw('sum(customer_orders.quantity) as total_quantity'),DB::raw('sum(customer_orders.total) as total_sold')
        )

        ->groupByRaw('customer_orders.product_name')
        ->orderBy('transactions.purchase_date')

        ->paginate(5); */

        $month = substr($date, 5);
        $year = substr($date, 0,-3); 


       /*  return transactions::with('customer')->whereMonth('purchase_date', $month)->get(); */


        return $customer = DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price',

        DB::raw('DATE_FORMAT(purchase_date, "%m/%d/%y %r") AS purchase_date')

        ,DB::raw('MONTHNAME(transactions.purchase_date) as Month'),
        DB::raw('sum(customer_orders.quantity) as total_quantity'),DB::raw('sum(customer_orders.total) as total_sold'))

        ->whereYear('transactions.purchase_date', $year)

        ->where(function($query) use($month)  {
            return $query
              ->whereMonth('transactions.purchase_date',$month);
        })

        ->groupByRaw('customer_orders.product_name')
        ->orderBy('transactions.purchase_date')
        ->paginate(5);

        /* return transactions::with('customer')->whereYear('purchase_date', $year)
        ->where(function($query) use($month)  {
              return $query
                ->whereMonth('purchase_date',$month);
        })
        ->paginate(5); 
 */

    }


}
