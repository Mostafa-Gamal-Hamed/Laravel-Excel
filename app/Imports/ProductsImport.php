<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Tables
        $valid   = session()->get('validTable');
        $inValid = session()->get('invalidTable');
        // Insert data
        for ($i=0; $i < $row; $i++) {
            return DB::table($valid)->insert($row);
            return DB::table($inValid)->insert($row);
        }
    }
}
