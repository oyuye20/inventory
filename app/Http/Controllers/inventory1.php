<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product_info;
use App\Models\category;
use App\Models\inventory;
use App\Models\transactions;
use Illuminate\Support\Facades\DB;

use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;

class inventory1 extends Controller
{
    public function inventory_index()
    {
        return inventory::with('product')->where('stocks','>','0')
        ->orderBy('created_at')->groupBy('product_id')->paginate(5);
    }


    public function inventoryLists(){
        $search = request('query');
        $sortname = request('sort');
        $sortBy = request('sortBy');


        if($sortname && $sortBy){
            return DB::table('inventories as i')
            ->join('product_infos as p', 'i.product_id','=','p.id')
            ->join('suppliers as s', 'i.supplier_id','=','s.id')

            ->select('p.product_name','p.serial_number','p.image',
            'p.price','p.selling_price','i.category', 's.supplier_name','s.supplier_number'
            ,'s.supplier_email','i.stocks','i.expiration_date','i.safety_stocks',
            'i.expiration_date')


            ->where(function($query) use($search)  {
                return $query
                ->where('manufacturer','LIKE','%'.$search.'%')
                ->orWhere('serial_number','LIKE','%'.$search.'%')
                ->orWhere('product_name','LIKE','%'.$search.'%');
            })

            ->where('stocks','>','0')->orderBy($sortname, $sortBy)->paginate(10);
        }



        return DB::table('inventories as i')
        ->join('product_infos as p', 'i.product_id','=','p.id')
        ->join('suppliers as s', 'i.supplier_id','=','s.id')

        ->select('p.product_name','p.serial_number','p.image',
        'p.price','p.selling_price','i.category', 's.supplier_name','s.supplier_number'
        ,'s.supplier_email','i.stocks','i.expiration_date','i.safety_stocks',
        'i.expiration_date')

        ->where(function($query) use($search)  {
            return $query
            ->where('manufacturer','LIKE','%'.$search.'%')
            ->orWhere('serial_number','LIKE','%'.$search.'%')
            ->orWhere('product_name','LIKE','%'.$search.'%');
        })
        
        ->where('stocks','>','0')->paginate(5);


        /* return inventory::with('product')->where('stocks','>','0')
        ->whereHas('product', function ($query) {
         $query->orderBy('product_name')->groupBy('product_name');
        })->paginate(5); */
    }



    public function exportExcelInventory(){
        return Excel::download(new InventoryExport,'inventory.csv');
    }






    public function getSoldOutInventory(){
        return inventory::with('product')->where('stocks','=','0')->paginate(10);
    }


    public function getStockID($id){
        return inventory::where('id','=',$id)->get();
    }


    public function updateStockID(Request $request, $id){
        $r = json_decode($request->input("stock_data"),true);

        $stock = inventory::find($id);
        

        foreach($r as $value){
            $stock->update([
                'supplier'=>$value['supplier'],
                'supplier_email'=>$value['supplier_email'],
                'supplier_number'=>$value['supplier_number'],
                'stocks'=>$value['stocks'],
            ]);
        }

        
        return response()->json([
            "status" => 200
         ]);

    }   



    public function inventory_add(Request $request)
    { 
        inventory::create([
            "product_id" => $request->product_info,
            "category" => $request->category,
            "stocks" => $request->stocks,
            "production_date" => $request->prod_date,
            "expiration_date" => $request->exp_date,

            "supplier_id" => $request->supplier,

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

        $validated = $request->validate([
            'category' => 'unique:categories',
        ]);

        category::create([
            "category" => ucfirst($request->category),
            "description" => ucfirst($request->desc),
            "variation" => ucfirst($request->variation),
            "measure" => ucfirst($request->measure),
        ]);

         return response()->json([
            "status" => 200
         ]);
    }





    public function stockHistory(){
        return inventory::with('product')->orderBy('created_at','asc')->paginate(10);
    }


    public function index_category()
    {
        return category::orderBy('id')->where('isArchived',0)->paginate(5);
    }


    public function select_category()
    {
        return category::where('isArchived',0)->orderBy('category', 'asc')->get();
    }


    public function select_product_info($data)
    {

        return product_info::with('category')->whereHas('category', function ($query) use($data)  {
            $query->where('isArchived',0)->where(function($query) use($data)  {
              $query->where('category','=',$data);
            });
          })->orderBy('product_name', 'asc')->get();


       /*  return product_info::with('category')->orderBy('id')->where('isArchived',0)->get(); */
    }



    public function get_update_cat($id)
    {
        return category::find($id);
    }



    public function update_category(Request $request,$id){
        $r = json_decode($request->input("categoryData"),true);
        $cat = category::find($id);
        

        $cat->update([
            'category'=>ucfirst($r['category']),
            'description'=>ucfirst($r['description']),
        ]);

        
        
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
