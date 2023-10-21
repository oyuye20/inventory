<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product_info;
use App\Models\category;

class archive extends Controller
{
    public function indexProduct(){
        return product_info::with('category')->where('isArchived',1)->paginate(5);
    }

    public function indexCategory(){
        return category::where('isArchived',1)->paginate(5);
    }


    public function restoreCategory($id){
        $cat  = category::find($id);

        $cat->isArchived = '0';
        $cat->save();

        if($cat)
        {
            return response()->json([
                'message' => 'Category restored successfully'
            ]);
        }

        else {
            return response()->json([
                'message' => 'Category does not exists'
                
            ]);
        }
    }



    public function restoreProduct($id){
        $product  = product_info::find($id);

        $product->isArchived = '0';
        $product->save();

        if($product)
        {
            return response()->json([
                'message' => 'Product restored successfully'
            ]);
        }

        else {
            return response()->json([
                'message' => 'Product does not exists'
                
            ]);
        }
    }

}
