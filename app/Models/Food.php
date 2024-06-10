<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'food';
    protected $fillable = [
        'nama',
        'harga',
        'image'
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
          get: fn ($image) => url('/storage/food-images/'.$image)
        );
    }
}
