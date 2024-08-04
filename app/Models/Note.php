<?php

namespace App\Models;

use App\Models\Tag;
use App\Enums\NoteStatus;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected function casts(): array
    {
        return [
            'status' => NoteStatus::class,
        ];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug']  = $this->generateSlug($value);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $type)
    {
        return $query->where('status', $type);
    }

    public function tags()
    {
        // return $this->belongsToMany(Tag::class);
    }
}
