<?php

namespace App\Http\Controllers;

use App\Events\UpdateCar;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Part;
use App\Models\Check_item;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
  public function index(){
    $cars = Car::where('sale', 1)
    ->select(['id','name', 'price','speed','power','user_id','lvl',
    'color','rare','fuel_max'])
    ->with(['user' => fn($q) => $q->select('id', 'name')])
    ->orderByDesc('updated_at')
    ->get();

    return $cars;
  }

  public function indexGarage(){
    $cars = Car::query()
    ->where('user_id', Auth::id())
    ->where('sale', 0)
    ->orderByDesc('lvl')
    ->select([
      'id','name','speed','fuel','power','lvl','color','rare','fuel_max'
    ])
    ->withCount('parts')
    ->get();
    
    return $cars;
  }

  public function indexRace(){
    return Car::query()
      ->where('user_id', Auth::id())
      ->where('sale', 0)
      ->orderByDesc('lvl')
      ->select([
          'id','name','speed','fuel','power','lvl','color','rare','wins',
          'quantity','fuel_max'
      ])
      ->get();
  }

  public function returnCar(Request $request){
    $validated = $request->validate([
      'id' => ['required', 'integer', 'exists:cars,id']
    ]);

    $updated = Car::where('id', $validated['id'])
      ->where('sale', '!=', 0)
      ->update(['sale' => 0]);

    if ($updated) {
      UpdateCar::dispatch();
    }
  }

   public function sell(Request $request){
    $validated = $request->validate([
      'id' => ['required', 'integer', 'exists:cars,id,user_id,'.Auth::id()],
      'price' => ['required', 'integer', 'min:1', 'max:8000000']
    ]);

    $updated = Car::where('id', $validated['id'])
      ->where('user_id', Auth::id())
      ->update([
        'sale' => 1,
        'price' => $validated['price']
      ]);
      
    if ($updated) {
      UpdateCar::dispatch();
    }
  }

  public function store(Request $request){
    $validated = $request->validate([
      'name' => ['required', 'string'],
      'speed' => ['required', 'integer'],
      'power' => ['required', 'integer'], 
      'color' => ['required', 'string'],
    ]);

    $car = Car::create(array_merge(
        $validated,
        ['user_id' => Auth::id()]
    ));
  }

  //public function editStats(Request $request){
  //  $validated = $request->validate([
  //    'id' => ['required', 'integer', 'exists:cars,id,user_id,'.Auth::id()],
  //    'quantity' => ['required', 'integer'],
  //    'wins' => ['required', 'integer'],
  //  ]);
  //  $updated = Car::where('id', $validated['id'])
  //    ->where('user_id', Auth::id())
  //    ->update([
  //        'quantity' => $validated['quantity'],
  //        'wins' => $validated['wins']
  //  ]);
  //}

  public function show(Car $car)
  {
    return $car->loadCount('parts');
  }

  public function showRace(Car $car){
    return $car->load(['user' => function($query) {
      $query->select('id', 'name');
    }]);
  }

  public function win(Car $car, Request $request){
    $validated = $request->validate([
      'xp' => ['required']
    ]);

    $car->update([
      'quantity' => $car->quantity + 1,
      'wins' => $car->wins + 1,
      'lvl' => $car->lvl + $validated['xp']
    ]);
  }
  
  public function defeat(Car $car){
    $car->increment('quantity');
  }

  public function rareUp(Request $request){
     $validated = $request->validate([
        'id' => ['required', 'integer', 'exists:cars,id'],
        'price' => ['required', 'integer'],
    ]);

    $car = Car::find($validated['id']);

    $car->update([
      'rare' => $car->rare + 1,
      'fuel_max' => $car->fuel_max + 2,
    ]);

    Auth::user()->decrement('balance', $validated['price']);
  }

  public function startRace(Request $request){
    $validations = $request->validate([
      'id' => ['required', 'integer'],
      'price' => ['required', 'integer'],
    ]);

    Car::find($request->id)->decrement('fuel', $request->price);
  }

  public function rand(){
    return Car::query()
      ->where('user_id', '!=', Auth::id())
      ->where('sale', 0)
      ->with(['user' => fn($q) => $q->select('id','name')])
      ->select(['name','speed','power','rare','color','user_id'])
      ->inRandomOrder()
      ->first();
  }

  public function shop(){
    return Cache::remember('shop:cars', now()->addHours(2), function () {
      return Car::query()
        ->where('sale', 2)
        ->select(['id','name','price','speed','power',
        'lvl','color','rare','fuel_max'])
        ->get();
    });
  }

  public function buyInShop(Request $request){
    $validations = $request->validate([
      'id' => ['required', 'integer'],
      'price' => ['required', 'integer'],
    ]);

    Auth::user()->decrement('balance', $request->price);
    
    $car = Car::find($request->id);

    $newCar = $car->replicate();
    $newCar->sale = 0;
    $newCar->user_id = Auth::id();
    $newCar->save();

    Check_item::create([
      'car_id' => $request->id,
      'user_id' => Auth::id()
    ]);
  }

  public function fuelUpAll(){
    return DB::transaction(function () {
      $user = Auth::user();
      
      if ($user->balance > 10){
        $updated = $user->cars()
            ->where('sale', 0)
            ->whereColumn('fuel', '<', 'fuel_max')
            ->update([
                'fuel' => DB::raw('fuel + 1')
            ]);
            
        $user->decrement('balance', 10);
      }
    });
  }
}