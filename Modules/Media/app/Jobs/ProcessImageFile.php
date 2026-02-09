<?php

namespace Modules\Media\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Media\Enums\MediaStatusEnum;
use Modules\Media\Models\Media;

class ProcessImageFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Media $media) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::alert('Processing image file: '.$this->media->id); // More specific log message

        try {
            $this->media->status = MediaStatusEnum::PROCESSED;
            $this->media->save();
            Log::info('Image file processed successfully: '.$this->media->id); // Log success
        } catch (\Exception $e) {
            Log::error('Error processing image file '.$this->media->id.': '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }
}
