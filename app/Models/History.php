<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history_order';
    protected $fillable = [
        'nama',
        'harga',
        'jumlah',
        'total_harga'
    ];
}
