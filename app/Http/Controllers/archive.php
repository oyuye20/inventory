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

}
