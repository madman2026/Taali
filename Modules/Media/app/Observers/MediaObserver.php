<?php

namespace Modules\Media\Observers;

use Illuminate\Support\Facades\Log;
use Modules\Media\Enums\MediaStatusEnum;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Jobs\ProcessAudioFile;
use Modules\Media\Jobs\ProcessImageFile;
use Modules\Media\Models\Media;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function created(Media $media): void
    {
        Log::alert('media Created', ['content' => $media]);
        switch ($media->type) {
            case MediaTypeEnum::IMAGE:
                ProcessImageFile::dispatch($media);
                break;
            case MediaTypeEnum::AUDIO:
                ProcessAudioFile::dispatch($media);
                break;
            case MediaTypeEnum::VIDEO:
                $media->status = MediaStatusEnum::PROCESSED;
                $media->save();
                break;
        }
    }

    /**
     * Handle the Media "updated" event.
     */
    public function updated(Media $media): void {}

    /**
     * Handle the Media "deleted" event.
     */
    public function deleted(Media $media): void {}

    /**
     * Handle the Media "restored" event.
     */
    public function restored(Media $media): void {}

    /**
     * Handle the Media "force deleted" event.
     */
    public function forceDeleted(Media $media): void {}
}
