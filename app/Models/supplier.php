<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name','supplier_number','supplier_email','isArchived'
    ];


    public function inventory(){
        return $this->hasMany(inventory::class);
    }
}
