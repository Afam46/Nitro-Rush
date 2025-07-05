<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectRace extends Model
{
    protected $table = 'race_objects'; 

    protected $fillable = ['race_id','z_index','size'];

    public $timestamps = false;
}
