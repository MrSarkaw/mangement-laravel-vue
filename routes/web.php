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

Route::get('/login', function () {
    return view('layouts.admin');
})->name("login");

Route::get('/', function () {
    return view('layouts.admin');  
});

Route::get('{path}',function(){
    return view("layouts.admin");
})->where('path','.*');


