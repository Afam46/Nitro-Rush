<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\GearController;
use App\Models\Check_item;
use App\Models\ObjectRace;

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
    Route::post('/defeat/{car}','defeat');
    Route::post('/rareUp', 'rareUp');
    Route::post('/startRace', 'startRace');
    Route::get('/rand','rand');
    Route::get('/shop','shop');
    Route::post('/buyInShop','buyInShop');
    Route::post('/fuelUpAll','fuelUpAll');
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
    Route::post('/takeOffAll', 'takeOffAll');
    Route::post('/sell', 'sell');
    Route::get('/rand','rand');
    Route::post('/fallingOut', 'fallingOut');
    Route::get('/shop','shop');
    Route::post('/buyInShop','buyInShop');
});

Route::prefix('gears')->controller(GearController::class)
->group(function(){
    Route::get('/','index');
});

Route::get('/checkCars', function(){
    return Check_item::query()
        ->where('user_id', Auth::id())
        ->whereNull('part_id')
        ->select(['id', 'car_id'])
        ->get();
});
Route::get('/checkParts', function(){
    return Check_item::query()
        ->where('user_id', Auth::id())
        ->whereNull('car_id')
        ->select(['id', 'part_id'])
        ->get();
});
Route::post('/raceObjectImg', function(Request $request){
    $validations = $request->validate([
      'id' => ['required', 'integer'],
    ]);

    return ObjectRace::where('race_id', $request->id)->get();
});