<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class customer_orders extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'transactions_id','product_name','quantity','price','total','serial_number'
        ,'selling_price'
    ];

    public function transactions(): BelongsTo{
        return $this->belongsTo(transactions::class);
    }
}
