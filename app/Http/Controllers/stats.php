<?php

namespace App\Http\Controllers;

use App\Models\customer_orders;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Support\Facades\DB;
use App\Models\inventory;
use App\Models\product_info;

class stats extends Controller
{
    

    /* FOR TOTAL NUMBER OF PRODUCTS IN DASHBOARD*/
    public function total_prod(){
        $product_count = product_info::where('isArchived', 0)->count();

        return response()->json([
            'product_count' => $product_count,
            'code' => 200
        ]);
    }


    /* REMINDER OF EXPIRED PRODUCTS WITH PAGINATION*/
    public function expiration(){
        return inventory::whereDate('expiration_date', '<', now())->paginate(5);

       /*  return response()->json([
            'expiration_date' => $p,
            'code' => 200
        ]); */

    }


    /* NUMBER OF EXPIRED PRODUCTS */
    public function expired_count(){
        $p = inventory::whereDate('expiration_date', '<', now())->count();

        return response()->json([
            'exp_count' => $p,
            'code' => 200
        ]);

    }


    /* TOTAL OF SUM STOCKS IN DASHBOARD*/
    public function stock_total(){
        $total_stock = inventory::select('stocks')->sum('stocks');

        return response()->json([
            'stock_total' => $total_stock,
            'code' => 200
        ]);
    }



    /* NUMBER OF CRITICAL STOCKS IN DASHBOARD*/
    public function critical_stocks(){
        $safe_stocks = 30;
        return inventory::where('stocks', '<', $safe_stocks)->get();

    }



    /* TOTAL SALES ITEMS */
    public function total_sales(){
        $sum = DB::table('transactions')->sum('net_total');

        return response()->json([
            'total_sales' => $sum,
            'code' => 200
        ]);
    }

    public function sold_items(){
        /* SELECT
        pi.id,
        pi.product_name,
        pi.price,
        inv.id,
        SUM(inv.stocks) AS total_quantity
        FROM
            product_info pi
        JOIN
            inventory inv
        ON
            pi.id = inv.product_id
        GROUP BY
            pi.id, pi.product_name, pi.price, inv.product_id
         HAVING
    		SUM(inv.stocks) < 100; */



       /*  $sold = DB::table('inventory')->groupBy('product_name')
        ->selectRaw('product_name,sum(quantity) as sold_items')
        ->orderBy('quantity', 'ASC')
        ->get();
 */

        $sold =  DB::table('customer_orders')
        ->selectRaw('product_name,sum(quantity) as sold_items, sum(total) as money')
        ->orderBy('money', 'DESC')
        ->groupBy('product_name')
        ->get();
        

        return response()->json([
            'sold' => $sold,
            'code' => 200
        ]);
    }



    public function dailyItems(){
        return $customer = DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price','transactions.purchase_date',
        DB::raw('sum(customer_orders.quantity) as total_quantity'),
        DB::raw('sum(customer_orders.total) as total_sold'))


        ->whereDate('transactions.purchase_date','=',now())
        ->groupBy('customer_orders.product_name')
        ->paginate(5);



        /* SELECT customer_name,net_total,MONTHNAME(purchase_date), SUM(net_total), COUNT(customer_name)
        FROM transactions
        WHERE MONTHNAME(purchase_date) = 'September' 
        GROUP BY MONTHNAME(purchase_date); */
    }


    public function monthlyItems(){
        return $customer = DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price',
        'transactions.purchase_date',DB::raw('MONTHNAME(transactions.purchase_date) as Month'),
        DB::raw('sum(customer_orders.quantity) as total_quantity'),DB::raw('sum(customer_orders.total) as total_sold')
        )

        ->groupByRaw('customer_orders.product_name')
        ->orderBy('transactions.purchase_date')

        ->paginate(5);
    }


    


}
