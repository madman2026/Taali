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
use Modules\Media\Models\Media;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

// use Modules\Content\Database\Factories\ContentFactory;

class Content extends Model
{
    use HasFactory , HasSEO , HasSlug;

    /**
     * The attributes that are mass assignable.
     */
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
        'published_at',
        'type' => ContentTypeEnum::class,
    ];

    /**
     * @return BelongsTo<\Modules\User\Models\User, Content>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }

    /**
     * @return HasMany<Media>
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
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
     * @return HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // protected static function newFactory(): ContentFactory
    // {
    //     // return ContentFactory::new();
    // }
}
