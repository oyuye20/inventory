<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id','category','stocks','production_date','expiration_date','status',
        'supplier','safety_stocks'
    ];

    protected $casts = [
        'production_date' => 'datetime:m-d-Y h:i:s a',
        'expiration_date' => 'datetime:m-d-Y h:i:s a',
    ];



    public function product() /* : BelongsTo */{
        return $this->belongsTo(product_info::class);
    }
}
