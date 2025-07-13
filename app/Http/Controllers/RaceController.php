<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Race;

class RaceController extends Controller
{
    public function index(){
        $races = Cache::remember('races', 60*2, function(){
            return Race::all();
        });

        return $races;
    }

    public function show(Race $race){
        return $race;
    }
}
