<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = ['name'];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
