<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UpdatePart;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Part;
use App\Models\Check_item;

class PartController extends Controller
{
    public function index(){
        return Part::with('user')->where('sale', 1)
        ->orderBy('updated_at', 'desc')->get();
    }

    public function indexGarage(){
        $parts = Auth::user()->parts->where('sale', 0);

        return $parts;
    }

    public function takeOffAll(Request $request){
        $validations = $request->validate([
          'car_id' =>  ['required','integer']
        ]);

        $car = Car::find($request->car_id);
        $part = Part::where('car_id', $request->car_id);

        $sumSpeed = $part->sum('speed');
        $sumPower = $part->sum('power');
        $sumFuel = $part->sum('fuel');

        $car->decrement('speed', $sumSpeed);
        $car->decrement('power', $sumPower);
        $car->decrement('fuel_max', $sumFuel);

        $part->update([
            'car_id' => null
        ]);
    }

    public function returnPart(Request $request){
      UpdatePart::dispatch();

      $validations = $request->validate([
        'id' =>  ['required','integer']
      ]);

      Part::where('id', $request->id)->update([
          'sale' => 0
      ]);
    }

    public function equip(Request $request){
        $validations = $request->validate([
          'id' =>  ['required','integer'],
          'car_id' =>  ['required','integer']
        ]);

        $part = Part::find($request->id);
        $car = Car::find($request->car_id);

        $part->update([
            'car_id' => $request->car_id
        ]);

        $car->increment('power', $part->power);
        $car->increment('speed', $part->speed);
        $car->increment('fuel_max', $part->fuel);
    }

    public function takeOff(Request $request){
        $validations = $request->validate([
          'id' =>  ['required','integer'],
          'car_id' =>  ['required','integer']
        ]);

        $part = Part::find($request->id);
        $car = Car::find($request->car_id);

        $part->update([
            'car_id' => null
        ]);

        $car->decrement('power', $part->power);
        $car->decrement('speed', $part->speed);
        $car->decrement('fuel_max', $part->fuel);
        if($car->fuel > $car->fuel_max){
            while($car->fuel !== $car->fuel_max){
                $car->decrement('fuel');
            }
        }
    }

    public function sell(Request $request){
      UpdatePart::dispatch();

      $validations = $request->validate([
        'id' =>  ['required','integer'],
        'price' =>  ['required','integer']
      ]);

      $part = Part::find($request->id);

      if($part->user->id === Auth::id()){  
        $part->update([
          'sale' => 1,
          'price' => $request->price
        ]);
      }
    }

    public function rand(){
      $randPart = Part::inRandomOrder()->where('user_id', null)
      ->where('car_id', null)->first();

      return $randPart;
    }

    public function fallingOut(Request $request){
        $validations = $request->validate([
          'id' =>  ['required','integer'],
        ]);

        $prizePart = Part::find($request->id);

        $newPart = $prizePart->replicate();
        $newPart->user_id = Auth::id();
        $newPart->sale = 0;
        $newPart->save();

        return $newPart->id;
    }

    public function shop(){
        return Part::all()->where('sale', 2);
    }

    public function buyInShop(Request $request){
        $validations = $request->validate([
          'id' => ['required', 'integer'],
          'price' => ['required', 'integer'],
        ]);

        Auth::user()->decrement('balance', $request->price);

        $part = Part::find($request->id);

        $newPart = $part->replicate();
        $newPart->sale = 0;
        $newPart->user_id = Auth::id();
        $newPart->save();

        Check_item::create([
          'part_id' => $part->id,
          'user_id' => Auth::id()
        ]);
  }
}