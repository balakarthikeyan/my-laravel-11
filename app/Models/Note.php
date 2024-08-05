<?php

namespace App\Models;

use App\Models\Tag;
use App\Enums\NoteStatus;
use App\Traits\Sluggable;
use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // using global scope class
        // static::addGlobalScope(new ActiveScope);
    }

    /**
     * Cast Method
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
     * set Attribute Method
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

    /**
     * BelongsTo Method
     *
     * @return response()
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * BelongsToMany Method
     *
     * @return response()
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
