<?php

namespace App\Models;

use App\Casts\Json;
use App\Models\Category;
use App\Traits\ProductScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    // use ProductScopesTrait;

    protected $fillable = [
        'name',
        'details',
        'category_id',
        'status',
        'specs',
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specs' => Json::class,
            'featured' => 'boolean',
        ];
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => '$' . number_format($value / 100, 2),
            set: fn (string $value) => (int) str_replace(['$', ','], '', $value) * 100,
        );
    }

    /**
     * Determine display name of product
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getNameCodeAttribute()
    {
        return $this->name . ' ' . $this->product_code;
    }
}
