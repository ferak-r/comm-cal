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
//for test phpunit
Route::get('/import', 'App\Classes\BaseTransactionActions@getInput');

//Run project
Route::get('/', 'App\Classes\BaseTransactionActions@getAction');
//Route::get('/checkres', 'App\Classes\PrivateClient@checkres');
