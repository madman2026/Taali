<?php

namespace Modules\User\Models;

use App\Contracts\HasSettings;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Content\Models\Content;
use Modules\Interaction\Models\Comment;
use Modules\Interaction\Models\Comment as InteractionComment;
use Modules\Interaction\Models\Like;
use Modules\Interaction\Models\View;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Models\Media;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserStatusEnum;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

// use Modules\User\Database\Factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory , HasRoles, HasSettings, HasTranslations, Notifiable, SoftDeletes;

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

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
