<?php

namespace Modules\Content\Models;

use App\Contracts\HasSlug;
use App\Contracts\Interactable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Content\Database\Factories\ContentFactory;
use Modules\Content\Enums\ContentStatusEnum;
use Modules\Content\Enums\ContentTypeEnum;
use Modules\Content\Models\Scopes\ApprovedContentScope;
use Modules\Content\Observers\ContentObserver;
use Modules\Media\Enums\MediaStatusEnum;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Models\Media;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

#[ObservedBy(ContentObserver::class)]
class Content extends Model
{
    /** @use HasFactory<ContentFactory> */
    use HasFactory, HasSEO, HasSlug, Interactable, SoftDeletes , HasUuids;

    protected $fillable = [
        'slug',
        'user_id',
        'type',
        'title',
        'excerpt',
        'description',
        'status',
        'published_at',
        'error',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'published_at' => 'datetime',
        'status' => ContentStatusEnum::class,
        'type' => ContentTypeEnum::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ApprovedContentScope);
    }

    public function scopeRejected($query)
    {
        return $query->withoutGlobalScope(ApprovedContentScope::class)
            ->where('status', ContentStatusEnum::REJECTED);
    }

    public function scopePending($query)
    {
        return $query->withoutGlobalScope(ApprovedContentScope::class)
            ->where('status', ContentStatusEnum::PENDING);
    }

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

    public function mediaProcessed(): bool
    {
        return $this->media()->exists() &&
            $this->media()->whereStatus(MediaStatusEnum::PENDING->value)
                ->orWhere('status', MediaStatusEnum::FAILED->value)
                ->doesntExist();
    }

    public function scopePublished($query)
    {
        return $query->where('status', ContentStatusEnum::APPROVED->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    protected static function newFactory(): ContentFactory
    {
        return ContentFactory::new();
    }
}
