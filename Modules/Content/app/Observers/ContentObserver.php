<?php

namespace Modules\Content\Observers;

use Illuminate\Support\Facades\Bus;
use Modules\Content\Jobs\ManagePendingOrRejectedContent;
use Modules\Content\Models\Content;
use Modules\Interaction\Jobs\MonitorCommentStatusAndRemoveOldComment;
use Modules\Interaction\Models\Comment;

class ContentObserver
{
    public function created(Content $content)
    {
        Bus::batch([
            (new ManagePendingOrRejectedContent($content->id))->onQueue('manage-contents'),
            (new MonitorCommentStatusAndRemoveOldComment(Comment::find($content->id)->id))->onQueue('manage-comments'),
        ])->dispatch();
        //        dispatch(new ManagePendingOrRejectedContent($content->id));
    }

    public function updating(Content $content) {}

    public function updated(Content $content) {}
}
