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

class CarController extends Controller
{
  public function index(){
    //$cars = Cache::remember('market:cars', 60*2, function(){
    //  return Car::with('user')->where('sale', 1)->orderBy('updated_at', 'desc')->get();
    //});

    return Car::where('sale', 1)->with('user')->orderBy('updated_at', 'desc')->get();
  }

  public function indexGarage(){
    $cars = Car::select('id','name','img','speed','fuel',
    'power','lvl','color','rare','fuel_max'
    )->where('user_id', Auth::id())->where('sale', 0)->orderBy('lvl', 'desc')
    ->withCount('parts')->get();

    return [$cars, $cars->count()];
  }

  public function indexRace(){
    $cars = Car::select('id','name','img','speed','fuel','power','lvl','color',
    'rare','wins','quantity','fuel_max')->where('user_id', Auth::id())
    ->orderBy('lvl', 'desc')->where('sale', 0)->get();

    return $cars;
  }

  public function returnCar(Request $request){
    UpdateCar::dispatch();

    $validations = $request->validate([
      'id' =>  ['required','integer']
    ]);

    //$cars = Cache::get('market:cars', collect([]));
    //$carId = $request->id;

    //$updatedCars = $cars->reject(function($car) use($carId){
    //  return $car->id == $carId;
    //});

    //Cache::put('market:cars', $updatedCars, 60*2);

    Car::where('id', $request->id)->update([
        'sale' => 0
    ]);
  }

   public function sell(Request $request){
    UpdateCar::dispatch();

    $validations = $request->validate([
      'id' =>  ['required','integer'],
      'price' => ['required', 'integer']
    ]);

    $car = Car::find($request->id);

    if($car->user->id === Auth::id()){ 
      $car->update([
        'sale' => 1,
        'price' => $request->price
      ]);
      //$cars = Cache::get('market:cars', []);
      //$cars = collect($cars)->prepend($car)->all();
      //Cache::put('market:cars', $cars, 60*2);
    }
  }

  public function store(Request $request){
    $validations = $request->validate([
        'name' =>  ['required'],
        'img' =>  ['required'],
        'speed' =>  ['required', 'integer'],
        'power' =>  ['required', 'integer'],
        'color' => ['required'],
    ]);

    Car::create([
        'name' => $request['name'],
        'img' => $request['img'],
        'speed' => $request['speed'],
        'power' => $request['power'],
        'color' => $request['color'],
        'user_id' => Auth::id()
    ]);
  }

  public function editStats(Request $request){
    $validations = $request->validate([
      'id' => ['required', 'integer'],
      'quantity' =>  ['required', 'integer'],
      'wins' =>  ['required', 'integer'],
    ]);

    Car::where('id', $request->id)->update([
      'quantity' => $request['quantity'],
      'wins' => $request['wins'],
    ]);
  }

  public function show(Car $car){
    return Car::where('id',$car->id)->withCount('parts')->get();
  }
  public function showRace(Car $car){
    return $car;
  }

  public function win(Car $car, Request $request){
    $validations = $request->validate([
      'win' =>  ['required', 'integer'],
      'xp' => ['required'],
    ]);
    
    $car->increment('quantity');
    $car->increment('lvl', $request->xp);
    $car->increment('wins', $request->win);
  }

  public function levelUp(Request $request){
    $validations = $request->validate([
      'id' => ['required', 'integer'],
      'price' =>  ['required', 'integer'],
    ]);

    $car = Car::find($request->id);

    Auth::user()->decrement('balance',$request->price);

    $car->increment('rare');
    $car->increment('fuel_max',2);
  }

  public function startRace(Request $request){
    $validations = $request->validate([
      'id' => ['required', 'integer'],
      'price' => ['required', 'integer'],
    ]);

    Car::find($request->id)->decrement('fuel', $request->price);
  }

  public function rand(){
    $randCar = Car::inRandomOrder()->whereNot('user_id', Auth::id())
    ->where('sale',0)->with('user')->first();

    return $randCar;
  }

  public function shop(){
    $cars = Cache::remember('shop:cars', 60*2, function(){
      return Car::where('sale', 2)->get();
    });

    return $cars;
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
    $user = Auth::user();
    $cars = $user->cars->where('sale', 0);

    foreach($cars as $car){
      if($car->fuel < $car->fuel_max){
        $car->increment('fuel');
      }
    }

    $user->decrement('balance', 10);
  }

  /*public function store(Request $request)
  {   
      $validations = $request->validate([
          'title' =>  ['required'],
          'price' =>  ['required'],
          'category_id' =>  ['required','exists:categories,id'],
          'img' =>  ['required'],
          'descrip' => ['required'],
      ]);

      $image = $request['img'];
      $name = md5($image->getClientOriginalName()).'.'.
      $image->getClientOriginalExtension();
      $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);

      Flower::create([
          'title' => $request['title'],
          'price' => $request['price'],
          'category_id' => $request['category_id'],
          'use_time_water' => $request['use_time_water'],
          'img' => url( '/storage' . '/' . $filePath, ),
          'descrip' => $request['descrip'],
      ]);

      return redirect(route('flowers'));
  }


  public function update(Request $request, Flower $flower)
  {   
      $validations = $request->validate([
          'title' =>  ['required'],
          'price' =>  ['required'],
          'category_id' =>  ['required'],
          'img' =>  ['required'],
          'descrip' => ['required'],
      ]);

      
      $image = $request['img'];
      $name = md5($image->getClientOriginalName()).'.'.
      $image->getClientOriginalExtension();
      $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);

      Flower::where('id', $flower->id)->update([
          'title' => $request->title,
          'price' => $request->price,
          'category_id' => $request->category_id,
          'use_time_water' => $request->use_time_water,
          'img' => url( '/storage' . '/' . $filePath, ),
          'descrip' => $request['descrip'],
      ]);

      return redirect(route('flowers'));
  }
  */

  /*public function delete(Car $car)
  {
      Car::destroy($car->id);

      return redirect(route('cars'));
  }
  */
}
