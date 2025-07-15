<?php

namespace App\Http\Controllers;

use App\Events\UpdateCar;
use App\Events\UpdatePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Car;
use App\Models\Part;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        return Auth::user()->only(['id','name','balance']);
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
        return DB::transaction(function () use ($request) {
            $car = Car::where('id', $request->id)
                    ->where('sale', 1)
                    ->lockForUpdate()
                    ->firstOrFail();

            $buyer = User::where('id', $request->user_id)
                    ->lockForUpdate()
                    ->firstOrFail();

            $seller = User::where('id', $car->user_id)
                    ->lockForUpdate()
                    ->firstOrFail();

            if ($buyer->balance > $request->price) {
                $car->update([
                    'sale' => 0,
                    'user_id' => $buyer->id,
                ]);

                $buyer->decrement('balance', $request->price);
                $seller->increment('balance', $request->price);

                UpdateCar::dispatch();
            }
        });
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