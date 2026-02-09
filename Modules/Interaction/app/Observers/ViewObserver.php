<?php

namespace Modules\Interaction\Observers;

use Modules\Interaction\Models\View;

class ViewObserver
{
    /**
     * Handle the ViewObserver "created" event.
     */
    public function created(View $view): void {}

    /**
     * Handle the ViewObserver "updated" event.
     */
    public function updated(View $view): void {}

    /**
     * Handle the ViewObserver "deleted" event.
     */
    public function deleted(View $view): void {}

    /**
     * Handle the ViewObserver "restored" event.
     */
    public function restored(View $view): void {}

    /**
     * Handle the ViewObserver "force deleted" event.
     */
    public function forceDeleted(View $view): void {}
}
