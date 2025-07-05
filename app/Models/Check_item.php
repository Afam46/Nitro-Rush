<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check_item extends Model
{
    protected $table = 'check_items'; 

    protected $fillable = ['car_id','user_id','part_id'];

    public $timestamps = false;
}