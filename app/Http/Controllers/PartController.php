<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UpdatePart;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Part;
use App\Models\Check_item;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PartController extends Controller
{
    public function index(){
      return Part::query()
        ->where('sale', 1)
        ->with(['user' => fn($q) => $q->select('id', 'name')])
        ->select(['id','name', 'price','speed','power','user_id','lvl','fuel','img'])
        ->orderByDesc('updated_at')
        ->get();
    }

    public function indexGarage(Car $car){
      return Auth::user()
        ->parts()
        ->where('sale', 0)
        ->with(['car' => fn($q) => $q->select('id')])
        ->select(['id','name','speed','power','lvl','fuel','img','car_id'])
        ->orderByRaw('
            CASE 
                WHEN car_id = ? THEN 0  -- Сначала детали текущей машины
                WHEN car_id IS NULL THEN 1  -- Затем непривязанные детали
                ELSE 2  -- Все остальные в конце
            END
        ', [$car->id])
        ->get();
    }

    public function returnPart(Request $request){
      $validated = $request->validate([
          'id' => ['required', 'integer', 'exists:parts,id,user_id,'.Auth::id()]
      ]);

      DB::transaction(function () use ($validated) {
        $part = Part::where('id', $validated['id'])
                ->where('user_id', Auth::id())
                ->where('sale', 1)
                ->firstOrFail();

        $part->update(['sale' => 0]);

        UpdatePart::dispatch();
      });
    }

   public function equip(Request $request){
      $validated = $request->validate([
          'id' => ['required', 'integer', 'exists:parts,id,user_id,'.Auth::id()],
          'car_id' => ['required', 'integer', 'exists:cars,id,user_id,'.Auth::id()]
      ]);

      return DB::transaction(function () use ($validated) {
        $part = Part::where('id', $validated['id'])
                ->where('user_id', Auth::id())
                ->whereNull('car_id')
                ->lockForUpdate()
                ->firstOrFail();

        $car = Car::where('id', $validated['car_id'])
               ->where('user_id', Auth::id())
               ->lockForUpdate()
               ->firstOrFail();

        $car->update([
            'power' => DB::raw("power + {$part->power}"),
            'speed' => DB::raw("speed + {$part->speed}"), 
            'fuel_max' => DB::raw("fuel_max + {$part->fuel}")
        ]);

        $part->update(['car_id' => $car->id]);
      });
    }

    public function takeOff(Request $request){
      $validated = $request->validate([
          'id' => ['required', 'integer', 'exists:parts,id,car_id,'.$request->car_id],
          'car_id' => ['required', 'integer', 'exists:cars,id,user_id,'.Auth::id()]
      ]);

      return DB::transaction(function () use ($validated) {
        $part = Part::where('id', $validated['id'])
                ->where('car_id', $validated['car_id'])
                ->lockForUpdate()
                ->firstOrFail();

        $car = Car::where('id', $validated['car_id'])
               ->where('user_id', Auth::id())
               ->lockForUpdate()
               ->firstOrFail();

        $part->update(['car_id' => null]);

        $car->update([
            'power' => DB::raw("GREATEST(0, power - {$part->power})"),
            'speed' => DB::raw("GREATEST(0, speed - {$part->speed})"),
            'fuel_max' => DB::raw("GREATEST(0, fuel_max - {$part->fuel})"),
            'fuel' => DB::raw("LEAST(fuel, GREATEST(0, fuel_max - {$part->fuel}))")
        ]);
      });
    }

    public function sell(Request $request){
      $validated = $request->validate([
        'id' => ['required', 'integer', 'exists:parts,id,user_id,'.Auth::id()],
        'price' => ['required', 'integer', 'min:1', 'max:8000000']
      ]);

      DB::transaction(function () use ($validated) {
        $part = Part::where('id', $validated['id'])
          ->where('user_id', Auth::id())
          ->where('sale', 0)
          ->lockForUpdate()
          ->firstOrFail();

        $part->update([
          'sale' => 1,
          'price' => $validated['price'],
        ]);

        UpdatePart::dispatch();
      });
    }

    public function rand(){
      return DB::transaction(function () {
        $randPart = Part::query()
            ->whereNull('user_id')
            ->whereNull('car_id')
            ->select(['id','name','img','power','speed','fuel','lvl'])
            ->lockForUpdate()
            ->inRandomOrder()
            ->firstOrFail();

        $newPart = $randPart->replicate()->fill([
            'user_id' => Auth::id(),
            'sale' => 0,
        ]);
        $newPart->save();

        return [
          'id' => $newPart->id,
          'name' => $newPart->name,
          'img' => $newPart->img,
        ];
      });
    }

    public function shop(){
      return Cache::remember('shop:parts', now()->addHours(2), function () {
        return Part::query()
          ->where('sale', 2)
          ->select(['id','name','price','img','power','speed','fuel','lvl'])
          ->get();
      });
    }

    public function buyInShop(Request $request){
      $validated = $request->validate([
        'id' => ['required', 'integer', 'exists:parts,id,sale,2'],
        'price' => ['required', 'integer', 'min:1']
      ]);

      return DB::transaction(function () use ($validated) {
        $user = User::where('id', Auth::id())
            ->lockForUpdate()
            ->firstOrFail();

        if ($user->balance > $validated['price']) {
          $part = Part::where('id', $validated['id'])
            ->where('sale', 2)
            ->firstOrFail();

          $newPart = $part->replicate()->fill([
            'sale' => 0,
            'user_id' => $user->id,
          ]);
          $newPart->save();

          $user->decrement('balance', $validated['price']);

          Check_item::create([
            'part_id' => $part->id,
            'user_id' => $user->id,
          ]);
        }
      });
    }
}