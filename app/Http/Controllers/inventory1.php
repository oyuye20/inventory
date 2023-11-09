<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product_info;
use App\Models\category;
use App\Models\inventory;
use App\Models\transactions;
use Illuminate\Support\Facades\DB;

class inventory1 extends Controller
{
    public function inventory_index()
    {
        /* $r =  inventory::with('product')->where('stocks','>',20)->get();

        foreach($r as $as) {
            echo $as->stocks;
        }
 */
        /* return inventory::with('product')->where('stocks','>', 100)->paginate(5); */

        return inventory::with('product')->paginate(5);


        /* return DB::table('product_infos')
        ->join('inventories','product_infos.id', '=','inventories.product_id')

        ->select('inventories.production_date', 'inventories.expiration_date', 
        'inventories.product_id', 'product_name', 
        'price', DB::raw('sum(inventories.stocks) as stocks') )
   
        ->groupBy('inventories.product_id','product_infos.price',
        'product_infos.product_name','inventories.expiration_date',
        'inventories.production_date')

        ->paginate(2); */
    }






    public function inventory_add(Request $request)
    { 
        inventory::create([
            "product_id" => $request->product_info,
            "category" => $request->category,
            "stocks" => $request->stocks,
            "production_date" => $request->prod_date,
            "expiration_date" => $request->exp_date,

            "supplier" => $request->supplier,
            "supplier_email" => $request->supplierEmail,
            "supplier_number" => $request->supplierNumber,


            "stock_by" => $request->stockBy,
            "updated_by" => $request->updatedBy,
            "safety_stocks" => $request->safetyStocks,
            "noExpiration" => $request->noExpiration,
            "status" => 'Good'
        ]);

        return response()->json([
            "status" => 200
         ]);
    }



    public function create_category(Request $request)
    {
        category::create([
            "category" => $request->category,
            "description" => $request->desc,
        ]);

         return response()->json([
            "status" => 200
         ]);
    }


    public function stockHistory(){
        return inventory::with('product')->orderBy('created_at','asc')->paginate(5);
    }


    public function index_category()
    {
        return category::orderBy('id')->where('isArchived',0)->paginate(5);
    }


    public function select_category()
    {
        return category::orderBy('id')->where('isArchived',0)->get();
    }


    public function select_product_info($data)
    {

        return product_info::with('category')->whereHas('category', function ($query) use($data)  {
            $query->where('isArchived',0)->where(function($query) use($data)  {
              $query->where('category','=',$data);
            });
          }) ->get();


       /*  return product_info::with('category')->orderBy('id')->where('isArchived',0)->get(); */
    }



    public function get_update_cat($id)
    {
        $category = category::find($id);

        return response()->json([
            'edit_cat' => $category
        ]);
    }



    public function update_category(Request $request,$id){
        
        /* $category = category::find($id)
        ->update([
            'category' => $request->input('category'),
            'description' => $request->input('description'),
        ]);


        if($category){
            return response()->json([
                'message' => 'category updated successfully'
            ]);
        } */
    }






    public function delete_category($id){
        $cat  = category::find($id);

        $cat->isArchived = '1';
        $cat->save();

        if($cat)
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
