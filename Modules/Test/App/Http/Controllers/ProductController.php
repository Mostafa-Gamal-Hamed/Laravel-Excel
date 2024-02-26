<?php

namespace Modules\Test\App\Http\Controllers;

use App\Exports\AllProductsExport;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\AllProductsImport;
use App\Imports\checkFileImport;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    // Show tables
    public function index()
    {
        $validTable = session()->get('validTable');
        if (Schema::hasTable($validTable)) {
            $valid          = DB::table($validTable)->get();
            $validColumns   = Schema::getColumnListing($validTable);
        }else{
            $valid          = DB::table("valid_products")->get();
            $validColumns   = Schema::getColumnListing($valid);
        }

        $invalidTable = session()->get('invalidTable');
        if(Schema::hasTable($invalidTable)){
            $invalid        = DB::table($invalidTable)->get();
            $invalidColumns = Schema::getColumnListing($invalidTable);
        }else{
            $invalid        = DB::table("in_valid_products")->get();
            $invalidColumns = Schema::getColumnListing($invalid);
        }

        return view('test::index', compact("validTable", "valid", "validColumns", "invalidTable", "invalid", "invalidColumns"));
    }

    // Check validate page
    public function check(Request $request)
    {
        // Validate
        $request->validate([
            "excel" => "required|file|mimes:xls,xlsx"
        ]);

        // Table names
        $validTable   = "valid_products_" . Str::random(10);
        $invalidTable = "in_valid_products_" . Str::random(10);

        // Import first row
        $row = Excel::toArray(new ProductsImport, $request->file('excel'));
        // First column
        $firstRow = $row[0][0];

        // Check if there any empty column
        foreach ($firstRow as $first) {
            if ($first == null) {
                return redirect()->back()->with("error", "There is empty column in first row");
            }
        }

        // check if validTable exist
        if(Schema::hasTable($validTable)) {
            return redirect()->back()->with("error", "The table is exist");
        }else{
            // Drop old table
            if(session()->has('validTable')){
                Schema::dropIfExists(session()->get('validTable'));
            }

            // Create The new table
            Schema::create($validTable, function ($table) use ($firstRow) {
                $table->id();
                foreach ($firstRow as $column) {
                    $table->string($column)->nullable();
                }
                $table->timestamps();
            });
        }

        // check if invalidTable exist
        if(Schema::hasTable($invalidTable)) {
            return redirect()->back()->with("error", "The table is exist");
        }else{
            // Drop old table
            if (session()->has('invalidTable')) {
                Schema::dropIfExists(session()->get('invalidTable'));
            }

            // Create The new table
            Schema::create($invalidTable, function ($table) use ($firstRow) {
                $table->id();
                foreach ($firstRow as $column) {
                    $table->string($column)->nullable();
                    $table->string($column . "_error")->nullable();
                }
                $table->timestamps();
            });
        }

        // Save tables name
        session()->put(['validTable' => $validTable, 'invalidTable' => $invalidTable]);

        // Storage file
        $storage   = Storage::putFile("excelFiles", $request->file('excel'));
        $excelName = session()->put("excelName", $storage);

        // Show first row
        $row = Excel::toArray(new checkFileImport, $request->excel);

        return view("test::check_file", compact("firstRow"));
    }

    // Import valid and inValid data
    public function import(Request $request)
    {
        // Excel file
        $storage = session()->get("excelName");
        $file    = Storage::path($storage);

        // Insert all data
        Excel::import(new AllProductsImport($request->validate), $file);

        return redirect('/')->with("success", "Added Successfully");
    }

    // Export valid
    public function export($tableName, $id)
    {
        $table = [$tableName, $id];
        return Excel::download(new ProductsExport($table), "Valid-" . $table[1] . '.xlsx');
    }

    // Export inValid
    public function exportInvalid($tableName, $id)
    {
        $table = [$tableName, $id];
        return Excel::download(new AllProductsExport($table), "Invalid-" . $table[1] . '.xlsx');
    }
}
