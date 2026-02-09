<?php

namespace Modules\Content\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Content\Enums\ContentStatusEnum;
use Modules\Content\Models\Content;
use Modules\Content\Notifications\ContentCreatedNotification;

class ManagePendingOrRejectedContent implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable , SerializesModels;

    public $content;

    public function __construct(int $id)
    {
        $this->content = Content::find($id);
        $this->onQueue('manage-contents');
    }

    public int $tries = 7;

    public function delay()
    {
        return 30;
    }

    public function backoff(): array
    {
        return [
            60,
            600,
            3600,
            7200,
            14400,
            28800,
            53600,
        ];
    }

    public function retryUntil(): \Illuminate\Support\Carbon|\Carbon\CarbonInterface
    {
        return now()->addDay();
    }

    public function middleware(): array
    {
        return [new RateLimited('content-create')];
    }

    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        if ($this->content->status === ContentStatusEnum::APPROVED) {
            return;
        }

        if ($this->content->status !== ContentStatusEnum::PENDING) {
            return;
        }

        try {
            if ($this->content->mediaProcessed()) {
                $this->content->update([
                    'status' => ContentStatusEnum::PROCESSED,
                ]);
            }
            $this->content->user->notify(new ContentCreatedNotification($this->content));
        } catch (\Throwable $e) {
            Log::error('Error in job: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            report($e);
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('content manage job error');
        $this->content->update([
            'error' => $exception->getMessage(),
            'status' => ContentStatusEnum::FAILED->value,
        ]);
    }
}
