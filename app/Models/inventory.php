<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class inventory extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id','category','stocks','status',
        'supplier_id','safety_stocks','production_date','expiration_date','stock_by','updated_by'
    ];

    protected $casts = [
        'production_date' => 'datetime:m-d-Y',
        'expiration_date' => 'datetime:m-d-Y',
        'created_at' => 'datetime:m-d-Y h:i:s a',
    ];



    public function product(){
        return $this->belongsTo(product_info::class);
    }


    public function supplier(){
        return $this->belongsTo(supplier::class);
    }
}
