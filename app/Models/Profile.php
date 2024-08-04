<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
