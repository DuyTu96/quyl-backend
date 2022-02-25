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

Route::get('/', function () {
    return response()->json(['status' => 'error','message' =>'Please check the API reference manual!']);
});
Route::get('/login',function(){
    return response()->json(['status' => 'error','message' =>'Please check the API reference manual!']);
})->name('login');

Route::get('/reset-password/{token}', function ($token) {
    return redirect('/auth/login/reset-password/'.$token);
})->middleware('guest')->name('password.reset');