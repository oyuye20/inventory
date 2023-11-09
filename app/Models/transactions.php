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
        'transactions_id','customer_name','gross_total','discount','net_total','status','purchase_date','change'
        ,'orderedBy'
    ];

    protected $casts = [
        'purchase_date' => 'datetime:m-d-Y h:i:s a',
    ];


    public function customer(): HasMany{
        return $this->hasMany(customer_orders::class);
    }

}
