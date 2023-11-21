<?php

namespace App\Exports;

use App\Models\inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class InventoryExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function headings(): array
    {
        return ["Product Name","Serial Number","Price","Selling Price",
        "Category","Supplier","Supplier Email","Production Date","Expiration Date","Stocks","Safety Stocks"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('inventories')
        ->join('product_infos', 'inventories.product_id','=','product_infos.id')

        ->select('product_infos.product_name','product_infos.serial_number',
        'product_infos.price','product_infos.selling_price','inventories.category',
        'inventories.supplier','inventories.supplier_number','inventories.production_date'
        ,'inventories.expiration_date',DB::raw('SUM(stocks) as stocksTotal, SUM(safety_stocks) as 
        safety_stocksTotal'))
        ->where('stocks','>','0')
        ->groupBy('inventories.product_id')->get();

    }
} 
