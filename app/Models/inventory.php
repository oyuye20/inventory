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
        'supplier','safety_stocks','production_date','expiration_date','supplier_email','supplier_number'
        ,'stock_by','updated_by'
    ];

    protected $casts = [
        'production_date' => 'datetime:m-d-Y h:i:s a',
        'expiration_date' => 'datetime:m-d-Y h:i:s a',
        'created_at' => 'datetime:m-d-Y h:i:s a',
    ];



    public function product(){
        return $this->belongsTo(product_info::class);
    }
}
