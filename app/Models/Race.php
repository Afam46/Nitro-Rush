<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ['name', 'price', 'img', 'prize', 'min_lvl'];

    public $timestamps = false;
}