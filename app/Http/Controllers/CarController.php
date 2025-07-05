<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Part;

class CarController extends Controller
{
  public function index(){
    return Car::with('user')->get()->where('sale', 1);
  }

  public function fuelUp(){
    
  }

  public function indexGarage(){
    $cars = Car::select('id','name','img','speed','fuel','power','lvl','color','rare'
    )->where('user_id', Auth::id())->where('sale', 0)->withCount('parts')->get();

    return [$cars, $cars->count()];
  }

  public function indexRace(){
    $cars = Car::select('id','name','img','speed','fuel','power','lvl','color',
    'rare','wins','quantity')->where('user_id', Auth::id())->where('sale', 0)->get();

    return $cars;
  }

  public function returnCar(Request $request){
    $validations = $request->validate([
      'id' =>  ['required','integer']
    ]);

    Car::where('id', $request->id)->update([
        'sale' => 0
    ]);
  }

   public function sell(Request $request){
    $validations = $request->validate([
      'id' =>  ['required','integer'],
      'price' => ['required', 'integer']
    ]);

    Car::where('id',$request->id)->update([
        'sale' => 1,
        'price' => $request->price
    ]);
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
    $car->increment('fuel',2);
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
    ->with('user')->first();

    return $randCar;
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
