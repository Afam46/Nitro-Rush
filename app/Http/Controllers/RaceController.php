<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;

class RaceController extends Controller
{
    public function index(){
        return Race::all();
    }
    public function show(Race $race){
        return $race;
    }
}
