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
        ->paginate(1); 
    }  


    public function searchInventory($data){
      return inventory::with('product')->where('product_name', $data)->paginate(1);

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
        'transactions.purchase_date',DB::raw('MONTHNAME(transactions.purchase_date) as Month'),
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
