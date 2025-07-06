<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Car;

class Part extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    protected $fillable = ['name', 'price', 'img','speed',
    'power','user_id','car_id','lvl','sale','fuel','updated_at',
    'created_at'];
}
