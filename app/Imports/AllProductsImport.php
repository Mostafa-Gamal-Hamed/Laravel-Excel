<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Test\App\Models\ValidProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Test\App\Models\DynamicModel;
use Modules\Test\App\Models\InValidProduct;
use Illuminate\Support\Str;

class AllProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $validations = [];

    public function __construct($validations)
    {
        $this->validations = $validations;
    }
    public function model(array $row)
    {
        // Tables
        $valid   = session()->get('validTable');
        $inValid = session()->get('invalidTable');
        // Validation
        $validator = Validator::make($row, $this->validations);
        if ($validator->fails()) {
            // Insert all columns to invalid table
            for ($i = 0; $i < $row; $i++) {
                $model = new DynamicModel($row);
                $model->changeTable($inValid);
                return $model;
            }
        } else {
            // Insert all columns to valid table
            for ($i = 0; $i < $row; $i++) {
                $model = new DynamicModel($row);
                $model->changeTable($valid);
                return $model;
            }
        }
    }
}
