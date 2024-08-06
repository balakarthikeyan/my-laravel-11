<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'category_id',
        'status'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // let's add another scope using anonymous function
        // static::addGlobalScope('status', function (Builder $builder) {
        //     $builder->where('status', 1);
        // });
    }

    /**
     * BelongsTo Method
     *
     * @return response()
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
