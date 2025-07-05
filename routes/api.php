<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\PartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('cars')->controller(CarController::class)
->group(function(){
    Route::get('/','index');
    Route::get('/garage','indexGarage');
    Route::get('/race','indexRace');
    Route::post('/returnCar', 'returnCar');
    Route::post('/sell', 'sell');
    Route::post('/store', 'store');
    Route::get('/show/{car}', 'show');
    Route::get('/showRace/{car}', 'showRace');
    Route::post('/win/{car}','win');
    Route::post('/levelUp', 'levelUp');
    Route::post('/startRace', 'startRace');
    Route::get('/rand','rand');
    Route::get('/fuelUp','fuelUp');
});

Route::prefix('user')->controller(UserController::class)
->group(function(){
    Route::get('/','index');
    Route::get('/balance', 'balance');
    Route::post('/balanceEdit','balanceEdit');
    Route::post('/sellPlayer','sellPlayer');
    Route::post('/sellPlayerPart','sellPlayerPart');
});

Route::prefix('races')->controller(RaceController::class)
->group(function(){
    Route::get('/','index');
    Route::get('/show/{race}','show');
});

Route::prefix('parts')->controller(PartController::class)
->group(function(){
    Route::get('/','index');
    Route::get('/garage','indexGarage');
    Route::post('/returnPart', 'returnPart');
    Route::post('/equip', 'equip');
    Route::post('/takeOff', 'takeOff');
    Route::post('/sell', 'sell');
});