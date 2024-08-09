<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Note;
use App\Models\Profile;
use App\Enums\UserStatus;
use App\Casts\UserStatusCast;
use Laravel\Passport\HasApiTokens;
// use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\UserStatusScope;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'display_name',
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
        // static::addGlobalScope(new UserStatusScope);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime:Y-m-d',
            'status' => UserStatusCast::class,
        ];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class)->withDefault(Profile::empty());
    }

    /**
     * Attribute Method
     *
     * @return Attribute
     */
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["user", "admin", "manager"][$value],
        );
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Determine display name of user
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getDisplayNameAttribute()
    {
        return strtoupper($this->attributes['name']);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $type = 1)
    {
        return $query->where('status', $type);
    }

    /**
     * 
     * @param Builder $builder
     * @return void
     */
    public function scopeEmailVerified(Builder $builder): void
    {
        $builder->whereNotNull('email_verified_at');
    }

    /**
     * @param Builder $query
     * 
     * @param string $role
     * @return void
     */
    public function scopeOfRole(Builder $query, string $role): void
    {
        $query->where('type', $role);
    }
}
