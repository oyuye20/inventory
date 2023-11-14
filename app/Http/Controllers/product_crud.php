<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\transactions;
use App\Models\customer_orders;
use App\Models\product_info;
use App\Models\category;
use App\Models\inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



use App\Models\Users;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;



class product_crud extends Controller
{

    public function exportProductExcel(){
       return Excel::download(new ProductsExport,'product.csv');
    }


    /* READ ALL PRODUCT */
    public function index(){
        return product_info::with('category')->where('isArchived',0)->orderBy('product_name')->paginate(10);
    }


    public function sample(){
        return transactions::with('customer_orders')->get();
    }


    /* CHECKOUT */
    public function checkout(Request $request){      
        $r = json_decode($request->input("cart"),true);

        /* $s = $request->input("grand_total");
        $converted = substr($s,3);
        $final_total = str_replace(',', '', $converted); */



        $transactions = transactions::create([ 
            "customer_name" => $request->input("customer_name"),
            "transactions_id" => $request->input("transactions_id"),
            "gross_total" => $request->input("sub_total"),
            "discount" => $request->input("discount"),
            "amount" => $request->input("amount"),
            "net_total" => $request->input("grand_total"),
            "purchase_date" => $request->input("purchase_date"),
            "orderedBy" => $request->input("orderedBy"),
            "change" => $request->input("change"),
            "status" => "Paid",
        ]);


        foreach($r as $values) {
            customer_orders::create([
                "transactions_id" => $transactions->id,
                "serial_number" => $values['serial_number'],
                "product_name" => $values['product_name'],
                "quantity" => $values['quantity'],
                "selling_price" => $values['selling_price'],
                "price" => $values['price'],
                "total" => $values['total'],
            ]);


        /* UPDATE inventories SET stocks = stocks - 5 WHERE product_id = 1 */


            inventory::where('id', $values['product_id'])->decrement('stocks',$values['quantity']);


            /* $update_quantity = DB::table('inventories')
            ->where('product_id', $values['product_id'])
            ->update(['stocks' => $values['quantity']]); */

            
            /* return $update_quantity = DB::table('inventory')
            ->select('product_id','product_id','stocks'
            ,DB::raw('MAX(created_at) as old'))

            ->where('product_id','=',1)
            ->update(['votes' => 1]); */
        

           /*  return $update_quantity = DB::table('inventory')
            ->select('product_id','stocks')
            ->groupBy('product_id', 'stocks')
            ->get(); */
            /* ->update(['stocks' => $stock_update]); */
            
         } 


        return response()->json([
            'code' => 200
        ]);
        
    }





    /* ADD NEW PRODUCT */
    public function add_product(Request $request){

        $validated = $request->validate([
            'category' => 'required',
            'manufacturer' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'size' => 'required',
            'price' => 'required',
            'sellingPrice' => 'required',
            'serial_number' => 'required|unique:product_infos',
        ]);


        if($validated){
            $product = new product_info();

        if ($request->hasFile('image')){
            $image = $request->file('image');

            $ext = $image->extension();
            $file = time().'.'.$ext;


            $image->storeAs('public/images', $file);
            $product->image = $file;
        }

       /*  $image = $request->file('image')->store('images','public'); */

        $product->category_id = $request->category;
        $product->serial_number = $request->serial_number;
        $product->manufacturer = $request->manufacturer;
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->selling_price = $request->sellingPrice;
  
        $product->save();
        }


        

        return response()->json([
            'message' => 'Product Added Successfully'
        ]);
    }


    /* GET DATA OF UPDATING PRODUCT */
    public function index_update_product($id){
        return product_info::find($id);
    }


    /* FOR UPDATING THE PRODUCT ITSELF */
    public function action_update_product(Request $request,$id){
        $r = json_decode($request->input("product_data"),true);

        $prod = product_info::find($id);

        if($request->hasFile('image2')){
            unlink(public_path('storage/images/'.$prod->image));

            $image = $request->file('image2');
            $ext = $image->extension();
            $file = time().'.'.$ext;
            $image->storeAs('public/images', $file);
            $prod->image = $file;
            $prod->save();
        }

        $prod->manufacturer = $r['manufacturer'];
        $prod->product_name = $r['product_name'];
        $prod->description = $r['description'];
        $prod->size = $r['size'];
        $prod->price = $r['price'];
        $prod->selling_price = $r['sellingPrice'];
        $prod->save();

        return response()->json([
            'message' => 'Product updated successfully'
        ]);
       
    }




    /* DELETE A PRODUCT */
    public function delete_product($id){
        $product  = product_info::find($id);

        $product->isArchived = '1';
        $product->save();

        if($product)
        {
            return response()->json([
                'message' => 'Product deleted successfully'
            ]);
        }

        else {
            return response()->json([
                'message' => 'Product does not exists'
                
            ]);
        }
    }
}
