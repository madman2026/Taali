<?php

namespace Modules\User\Models;

use App\Contracts\HasSettings;
use App\Contracts\Interactable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Content\Models\Content;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Models\Media;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserStatusEnum;
use Modules\User\Observers\UserObserver;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

// use Modules\User\Database\Factories\UserFactory;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory , HasRoles, HasSettings, HasTranslations, Interactable, Notifiable, SoftDeletes;

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
            'status' => UserStatusEnum::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
        ];
    }

    public function getAvatarAttribute()
    {
        return $this->media()->whereType(MediaTypeEnum::IMAGE->value)->first();
    }

    public function media()
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

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
