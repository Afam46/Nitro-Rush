<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Part;

class PartController extends Controller
{
    public function index(){
        return Part::with('user')->get()->where('sale', 1);
    }

    public function indexGarage(){
        $parts = Auth::user()->parts->where('sale', 0);

        return $parts;
    }

    public function returnPart(Request $request){
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
    }

    public function sell(Request $request){
        $validations = $request->validate([
          'id' =>  ['required','integer'],
          'price' =>  ['required','integer']
        ]);

        Part::where('id',$request->id)->update([
            'sale' => 1,
            'price' => $request->price
        ]);
    }
}