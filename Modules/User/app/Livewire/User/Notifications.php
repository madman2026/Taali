<?php

namespace Modules\User\Livewire\User;

use App\Contracts\HasNotifableComponent;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use HasNotifableComponent , WithPagination;

    protected $listeners = ['notificationReceived' => '$refresh'];

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        $this->success(__('notifications.marked_as_read'));
    }

    public function deleteNotification($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        $this->success(__('notifications.deleted'));
    }

    public function render()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view('user::livewire.user.notifications', compact('notifications'));
    }
}
