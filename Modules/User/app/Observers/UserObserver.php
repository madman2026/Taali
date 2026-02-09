<?php

namespace Modules\User\Observers;

use Modules\User\Models\User;

class UserObserver
{
    /**
     * Handle the UserObserver "created" event.
     */
    public function created(User $user): void {}

    /**
     * Handle the UserObserver "updated" event.
     */
    public function updated(User $user): void {}

    /**
     * Handle the UserObserver "deleted" event.
     */
    public function deleted(User $user): void {}

    /**
     * Handle the UserObserver "restored" event.
     */
    public function restored(User $user): void {}

    /**
     * Handle the UserObserver "force deleted" event.
     */
    public function forceDeleted(User $user): void {}
}
