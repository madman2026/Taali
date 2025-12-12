<?php

namespace Modules\Content\Models;

use App\Contracts\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Content\Enums\ContentTypeEnum;
use Modules\Interaction\Models\Comment;
use Modules\Interaction\Models\Like;
use Modules\Interaction\Models\View;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Models\Media;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

// use Modules\Content\Database\Factories\ContentFactory;

class Content extends Model
{
    use HasFactory, HasSEO, HasSlug;

    protected $fillable = [
        'slug',
        'user_id',
        'type',
        'title',
        'excerpt',
        'description',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'type' => ContentTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('type', MediaTypeEnum::IMAGE->value);
    }

    public function audio()
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('type', MediaTypeEnum::AUDIO->value);
    }

    public function video()
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('type', MediaTypeEnum::VIDEO->value);
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
