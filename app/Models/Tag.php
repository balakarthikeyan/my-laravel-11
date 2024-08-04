<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function notes()
    {
        // return $this->belongsToMany(Note:class);
    }

    public function products()
    {
        // return $this->morphedByMany(Product::class, 'taggable');
    }
}
