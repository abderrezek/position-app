<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Placed extends Model
{
    use HasFactory;

    public $fillable = [
        'uuid',
        'lat',
        'lng',
        'zoom',
        'email',
        'message',
        'url',
        'time',
        'count'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'lat' => 'double',
        'lng' => 'double',
        'zoom' => 'integer',
        'count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function getTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }

    public function getMessageAttribute($value)
    {
        return substr($value, 0, 15);
    }
}
