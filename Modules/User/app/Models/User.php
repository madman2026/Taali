<?php

namespace Modules\User\Models;

use App\Contracts\HasSettings;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Content\Models\Content;
use Modules\Interaction\Models\Comment as InteractionComment;
use Modules\Interaction\Models\Like;
use Modules\Interaction\Models\View;
use Modules\Media\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

// use Modules\User\Database\Factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory , HasRoles, HasSettings, HasTranslations, Notifiable, SoftDeletes;

    /**
     * Translatable attributes (if you plan to use localization for user names, etc.)
     *
     * @var array<int, string>
     */
    public array $translatable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'status',
        'email',
        'password',
        'settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be type cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
        ];
    }

    /**
     * Alias the legacy "status" column to an "is_active" attribute.
     */
    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes): bool => (bool) ($attributes['status'] ?? false),
            set: fn ($value): array => ['status' => (bool) $value]
        );
    }

    public function image()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    /**
     * Example custom accessor for full name (optional)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name ?: $this->email;
    }

    /**
     * @return HasMany<Content>
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    /**
     * @return HasMany<View>
     */
    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    /**
     * @return HasMany<Like>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * @return HasMany<InteractionComment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(InteractionComment::class);
    }
}
