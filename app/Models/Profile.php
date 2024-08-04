<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'address',
        'city',
        'country',
        'phone',
    ];

    public static function empty(): array
    {
        return [
            'user_id' => 0,
            'type' => 'user',
            'address' => '',
            'city' => '',
            'country' => '',
            'phone' => '',
        ];
    }
}
