<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $table;
    public function __construct($table)
    {
        $this->table = $table;
    }
    public function collection()
    {
        return DB::table($this->table[0])->where("id",$this->table[1])->get();
    }
}
