<?php

namespace Modules\Interaction\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Interaction\Enums\CommentStatusEnum;
use Modules\Interaction\Models\Comment;

class MonitorCommentStatusAndRemoveOldComment implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable , SerializesModels;

    public $comment;

    /**
     * Create a new job instance.
     */
    public function __construct(int $id)
    {
        $this->comment = Comment::find($id);
        $this->onQueue('manage-comments');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if (
            ! $this->comment
        ) {
            return;
        }

        if (
            $this->comment->status == CommentStatusEnum::APPROVED ||
            $this->comment->status == CommentStatusEnum::REJECTED
        ) {
            return;
        }

        if (
            $this->comment->isOld()
        ) {
            if (
                Comment::isSoftDeletable() ||
                $this->comment->deleted_at = null
            ) {
                $this->comment->delete();
            } else {
                $this->comment->forceDelete();
            }
        }

        if (
            $this->attempts() <= 4
        ) {
            return;
        } else {
            $this->release(\Illuminate\Support\now()->addMinutes(20));
        }
    }
}
