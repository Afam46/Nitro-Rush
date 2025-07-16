<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Race;

class RaceController extends Controller
{
    public function index(){
        return Cache::remember('races', now()->addHours(2), function () {
            return Race::query()
                ->select(['id','name','price','img','prize','min_lvl'])
                ->get();
        });
    }

    public function show(Race $race){
        return Cache::remember("races:".$race->id, now()->addHours(2), function () use ($race) {
            return $race;
        });
    }
}
