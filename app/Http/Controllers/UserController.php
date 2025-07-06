<?php

namespace App\Http\Controllers;

use App\Events\UpdateCar;
use App\Events\UpdatePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Car;
use App\Models\Part;

class UserController extends Controller
{
    public function index(){
        return Auth::user();
    }
    public function balance(){
        return Auth::user()->balance;
    }
    public function balanceEdit(Request $request){
        $validations = $request->validate([
          'price' =>  ['required','integer']
        ]);

        Auth::user()->increment('balance', $request->price);
    }
    public function sellPlayer(Request $request){
        UpdateCar::dispatch();

        $validations = $request->validate([
            'id' => ['required'],
            'price' =>  ['required'],
            'user_id' =>  ['required','integer']
        ]);

        $car = Car::find($request->id);
        $seller = $car->user;
        $buyer = User::find($request->user_id);

        Car::where('id',$request->id)->update([
            'sale' => 0,
            'wins' => 0,
            'quantity' => 0,
            'user_id' => $request->user_id
        ]);

        $buyer->decrement('balance', $request->price);
        $seller->increment('balance', $request->price);
    }

    public function sellPlayerPart(Request $request){
        UpdatePart::dispatch();

        $validations = $request->validate([
            'id' => ['required'],
            'price' =>  ['required'],
            'user_id' =>  ['required','integer']
        ]);

        $car = Part::find($request->id);
        $seller = $car->user;
        $buyer = User::find($request->user_id);

        Part::where('id',$request->id)->update([
            'sale' => 0,
            'user_id' => $request->user_id
        ]);

        $buyer->decrement('balance', $request->price);
        $seller->increment('balance', $request->price);
    }
}