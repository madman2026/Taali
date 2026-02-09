<?php

namespace Modules\Interaction\Observers;

use Modules\Interaction\Models\Like;

class LikeObserver
{
    /**
     * Handle the LikObserver "created" event.
     */
    public function created(Like $like): void {}

    /**
     * Handle the LikObserver "updated" event.
     */
    public function updated(Like $like): void {}

    /**
     * Handle the LikObserver "deleted" event.
     */
    public function deleted(Like $like): void {}

    /**
     * Handle the LikObserver "restored" event.
     */
    public function restored(Like $like): void {}

    /**
     * Handle the LikObserver "force deleted" event.
     */
    public function forceDeleted(Like $like): void {}
}
