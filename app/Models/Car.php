<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Part;

class Car extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

      public function parts(): HasMany
    {
        return $this->hasMany(Part::class, 'car_id', 'id');
    }

    protected $fillable = ['name', 'price','speed','fuel',
    'power','user_id','lvl','color','rare','sale','fuel_max','updated_at',
    'created_at','quantity', 'wins'];
}