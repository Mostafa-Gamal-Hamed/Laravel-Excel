<?php

use Illuminate\Support\Facades\Route;
use Modules\Test\App\Http\Controllers\ProductController;
use Modules\Test\App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('test', TestController::class)->names('test');
});


Route::controller(ProductController::class)->group(function() {
    // Show all
    Route::get('/','index');
    // Check file page
    Route::post('/check','check');
    // Import
    Route::post('/import','import');
    // export Valid
    Route::post('/export/{tableName}/{id}','export');
    // export Invalid
    Route::post('/exportInvalid/{tableName}/{id}','exportInvalid');
});
