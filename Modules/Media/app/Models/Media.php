<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\URL;
use Modules\Media\Enums\MediaStatusEnum;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Observers\MediaObserver;

#[ObservedBy(MediaObserver::class)]
class Media extends Model
{
    use HasFactory , HasUuids;

    protected $fillable = [
        'path',
        'type',
        'disk',
        'metadata',
        'status',
    ];

    protected $casts = [
        'status' => MediaStatusEnum::class,
        'type' => MediaTypeEnum::class,
        'metadata' => 'array',
    ];

    public function getTemporaryUrlAttribute()
    {
        return URL::temporarySignedRoute(
            'download',
            now()->addMinutes(10),
            ['id' => $this->id]
        );
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
