<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('home');
});

Auth::routes();

Route::get('{page}', function(){
    return view('home');
})->where('page','.*');


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');