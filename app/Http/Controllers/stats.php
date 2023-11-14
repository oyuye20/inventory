<?php

namespace App\Http\Controllers;

use App\Models\customer_orders;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Support\Facades\DB;
use App\Models\inventory;
use App\Models\product_info;
use Carbon\Carbon;

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
    public function expProduct(){
        return inventory::with('product')->whereDate('expiration_date', '<=', now())->paginate(10);
    }


    /* NUMBER OF EXPIRED PRODUCTS */
    public function expired_count(){
        return inventory::with('product')->whereDate('expiration_date', '<=', now())->count();
    }





    /* TOTAL OF SUM STOCKS IN DASHBOARD*/
    public function stock_total(){
        $total_stock = inventory::select('stocks')->sum('stocks');

        return response()->json([
            'stock_total' => $total_stock,
            'code' => 200
        ]);
    }



    /* LISTS OF ORDERS   */
    public function orders(){
        return transactions::orderBy('purchase_date','DESC')->paginate(10);
    }



    /* LISTS OF CRITICAL STOCKS*/
    public function criticalStocks(){


        /* SELECT product_id, SUM(stocks) as stocks1,SUM(safety_stocks) as 
        safeStocks FROM `inventories` GROUP BY product_id HAVING safeStocks > stocks1  */
 
        return DB::table('inventories as i')
        ->join('product_infos as p','i.product_id','=','p.id')

        ->select('p.product_name','p.serial_number','p.manufacturer','p.size',
        DB::raw('SUM(i.stocks) as stocks1,SUM(i.safety_stocks) as safeStocks'))
        ->groupBy('i.product_id')

        ->havingRaw('safeStocks > stocks1')
    
        ->paginate(10);



         /* return inventory::with('product')->whereColumn('safety_stocks','>','stocks')->paginate(10); */
    }



    /* COUNT OF CRITICAL STOCKS*/
    public function criticalStocksCount(){
        return inventory::with('product')->whereColumn('safety_stocks','>','stocks')->count();
    }



    public function supplierLists(){
        return inventory::select('supplier','supplier_number','supplier_email')->paginate(10);
    }






    public function expiringItems(){

        /* SELECT product_id, CURRENT_DATE, expiration_date, DATEDIFF(expiration_date, CURRENT_DATE) as diff FROM `inventories` HAVING diff = 90; */
        return inventory::with('product')
        ->where(DB::raw('DATEDIFF(expiration_date, CURDATE())'),'>=', 90)->paginate(10);
    }



    public function netSales(){
        return DB::table('customer_orders')
        ->selectRaw('SUM(selling_price * quantity) - SUM(price * quantity) as total')
        ->get();
    }



    /* FUNCTION FOR VIEW INVOICE ORDER */
    public function showInvoice($id){
        return DB::table('customer_orders')
        ->join('transactions','customer_orders.transactions_id', '=','transactions.id')
        ->where('transactions.id', '=', $id)
        ->get();

        /* return customer_orders::where('transactions_id','=',$id)->get(); */
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
        return DB::table('customer_orders as c')
        ->join('transactions as t','c.transactions_id', '=','t.id')
        
        ->selectRaw('t.purchase_date, c.serial_number, 
        c.product_name,sum(c.quantity) as sold_items, sum(c.total) as money, 
        c.price, c.selling_price, SUM(c.selling_price * c.quantity) - SUM(c.price * c.quantity) as net_total')
        ->orderBy('money', 'DESC')
        ->groupBy('c.product_name')
        ->paginate(10);

    }



    public function dailyItems(){
        return $customer = DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price',
        DB::raw('DATE_FORMAT(transactions.purchase_date, "%m/%d/%y %r") AS purchase_date'),
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
        DB::raw('DATE_FORMAT(purchase_date, "%m/%d/%y %r") AS purchase_date'),
        DB::raw('MONTHNAME(transactions.purchase_date) as Month'),
        DB::raw('sum(customer_orders.quantity) as total_quantity'),DB::raw('sum(customer_orders.total) as total_sold')
        )

        ->groupByRaw('customer_orders.product_name')
        ->orderBy('transactions.purchase_date')

        ->paginate(5);
    }



    public function monthlyItemsAnalytics(){

        /* $monthly =  DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price',
        DB::raw('DATE_FORMAT(purchase_date, "%m/%d/%y %r") AS purchase_date'),
        DB::raw('MONTHNAME(transactions.purchase_date) as Month'),
        DB::raw('sum(customer_orders.quantity) as total_quantity'),DB::raw('sum(customer_orders.total) as total_sold')
        )

        ->groupByRaw('Month')
        ->orderBy('transactions.purchase_date')

        ->get(); */

        $monthly = DB::table('transactions')
        ->selectRaw('MONTH(purchase_date) as month, sum(net_total) as total_sold')
        ->whereYear('purchase_date', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();


        $labels = [];
        $data = [];


        for($i=1; $i < 13; $i++){
            $month = date('F', mktime(0,0,0,$i,1));
            $count = 0;

            foreach($monthly as $m){
                if($m->month == $i){
                    $count = $m->total_sold;
                    break;
                }
            }


            array_push($labels, $month);
            array_push($data, $count);

        }


        return response()->json([
            'labels' => $labels,
            'total_sold' => $data
        ]);
    }










    public function yearlyItems(){
        return $customer = DB::table('transactions')
        ->join('customer_orders','transactions.id', '=','customer_orders.transactions_id')
        
        ->select('customer_orders.product_name','customer_orders.price',
        DB::raw('YEAR(purchase_date) AS yearOf'),
        DB::raw('DATE_FORMAT(purchase_date, "%m/%d/%y %r") AS purchase_date'),
        DB::raw('MONTHNAME(transactions.purchase_date) as Month'),
        DB::raw('sum(customer_orders.quantity) as total_quantity'),DB::raw('sum(customer_orders.total) as total_sold')
        )

        ->groupByRaw('customer_orders.product_name')
        ->orderBy('transactions.purchase_date')

        ->paginate(5);
    }


    


}
