<?php

namespace App\Exports;

use App\Models\product_info;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ProductsExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function headings(): array
    {
        return ["Category","Manufacturer","Product Name","Price",'Size'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('product_infos')
            ->join('categories', 'product_infos.category_id', '=', 'categories.id')
            ->select('categories.category', 'product_infos.product_name', 
            'product_infos.manufacturer','product_infos.price','product_infos.size')
            ->orderBy('product_infos.product_name')
            ->get();
    }
} 
