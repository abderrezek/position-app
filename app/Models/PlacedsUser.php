<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacedsUser extends Model
{
    use HasFactory;

    protected $table = 'placed_user';

    public $fillable = [
        'user_id',
        'placed_id',
    ];
}
