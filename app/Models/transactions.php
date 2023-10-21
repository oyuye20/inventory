<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class transactions extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'customer_name','gross_total','discount','net_total','status','purchase_date'
    ];

    public function customer(): HasMany{
        return $this->hasMany(customer_orders::class);
    }

}