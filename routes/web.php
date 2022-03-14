<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/import', 'App\Http\Controllers\CommissionCalculatorController@getInput');
Route::get('/import', 'App\Classes\BaseTransactionActions@getInput');
Route::get('/', 'App\Classes\BaseTransactionActions@getAction');
Route::get('/converter', 'App\Http\Controllers\CommissionCalculatorController@currencyConvert');
Route::get('/currency/{amount}/{currency}', 'App\Http\Controllers\CommissionCalculatorController@currencyConvert');
