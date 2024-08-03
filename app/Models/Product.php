<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'category_id'
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
