<?php

namespace App\Http\Controllers;
use App\Models\supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class supplier2 extends Controller
{
    public function index(){

        $search = request('query');
        $sortname = request('sort');
        $sortBy = request('sortBy');


        if($sortBy && $sortBy){
            return supplier::where('isArchived',0)
            
            ->where(function($query) use($search)  {
                return $query
                ->where('supplier_name','LIKE','%'.$search.'%')
                ->orWhere('supplier_number','LIKE','%'.$search.'%')
                ->orWhere('supplier_email','LIKE','%'.$search.'%');
            })

            ->orderBy($sortname, $sortBy)
            ->paginate(5);
        }


        return supplier::where('isArchived',0)
        ->where(function($query) use($search)  {
            return $query
            ->where('supplier_name','LIKE','%'.$search.'%')
            ->orWhere('supplier_number','LIKE','%'.$search.'%')
            ->orWhere('supplier_email','LIKE','%'.$search.'%');
        })
        ->paginate(5);
    }



    

    public function add(Request $request){
        $validated = $request->validate([
            'supplier_name' => 'unique:suppliers',
        ]);

        supplier::create([ 
            "supplier_name" => $request->supplier_name,
            "supplier_number" => $request->supplier_number,
            "supplier_email" => $request->supplier_email,

        ]);


        return response()->json([
            'message' => 'Supplier Added Successfully'
        ]);
    }

    public function selectSupplier(){
        return supplier::where('isArchived',0)->orderBy('supplier_name', 'desc')->get();
    }




    public function archive($id){
        $supplier  = supplier::find($id);

        $supplier->isArchived = '1';
        $supplier->save();

        if($supplier)
        {
            return response()->json([
                'message' => 'supplier archived successfully'
            ]);
        }

        else {
            return response()->json([
                'message' => 'Supplier does not exists'
                
            ]);
        }
    }


}

