<?php

namespace App\Http\Controllers;
use App\Models\supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class supplier2 extends Controller
{
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


}

