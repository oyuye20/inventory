<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product_info;
use League\CommonMark\Node\Query\AndExpr;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class filter extends Controller
{

    /* SEARCH BOX FOR PRODUCT NAME */
    public function search($data){

        return DB::table('product_infos')
           ->where('isArchived', 0)

           ->where(function (Builder $query) use($data) {
               $query->where('manufacturer','LIKE','%'.$data.'%')
               ->orWhere('product_name','LIKE','%'.$data.'%');
           })

        ->get();


        /* return product_info::with('category')
        ->where('manufacturer','LIKE','%'.$data.'%')
        ->orWhere('product_name','LIKE','%'.$data.'%')
        ->where(function (Builder $query) {
            $query->where('isArchived','0');
        })
        ->get(); */




/* 
        ->orWhere('manufacturer','LIKE','%'.$data.'%','AND','isArchived', 0)
        ->orWhere('product_name','LIKE','%'.$data.'%')
        ->where('isArchived', 0)
        ->paginate(1); */

        /* foreach($res as $r){
           if($r->isArchived == 1){
            return 'deleted';
           }

           else {
            return $res;
           }
        } */
        



        
    }  


}
