<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\URL;
use Modules\Media\Enums\MediaTypeEnum;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'type',
        'disk',
        'metadata',
    ];

    protected $casts = [
        'status' => MediaTypeEnum::class,
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
