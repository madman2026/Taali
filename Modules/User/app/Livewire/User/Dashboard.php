<?php

namespace Modules\User\Livewire\User;

use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

#[Layout('components.layouts.master')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public $user;

    public bool $isActive = false;

    public int $views = 0;

    public int $likes = 0;

    public int $commentsCount = 0;

    public int $contentsCount = 0;

    public Collection $contents;

    public function mount()
    {
        $this->user = Auth::user();
        $this->contents = collect();
        $this->loadData();
    }

    public function confirmToggleStatus(): void
    {
        $this->dispatch('openConfirmModal', data: [
            'title' => __('Toggle Account Status'),
            'message' => $this->isActive
                ? __('Are you sure you want to deactivate your account?')
                : __('Are you sure you want to activate your account?'),
            'confirmEvent' => 'toggleActivateAccount',
            'confirmButtonText' => $this->isActive ? __('Deactivate') : __('Activate'),
            'confirmColor' => $this->isActive ? 'amber' : 'green',
        ]);
    }

    public function confirmDeleteAccount(): void
    {
        $this->dispatch('openConfirmModal', data: [
            'title' => __('Delete Account'),
            'message' => __('This action is irreversible. Do you want to continue?'),
            'confirmEvent' => 'deleteAccount',
            'confirmButtonText' => __('Delete'),
            'confirmColor' => 'red',
        ]);
    }

    public function loadData(): void
    {
        $this->user->loadCount(['views', 'likes', 'comments', 'contents']);

        $this->views = (int) ($this->user->views_count ?? 0);
        $this->likes = (int) ($this->user->likes_count ?? 0);
        $this->commentsCount = (int) ($this->user->comments_count ?? 0);
        $this->contentsCount = (int) ($this->user->contents_count ?? 0);

        $this->contents = $this->user->contents()
            ->latest('created_at')
            ->withCount(['views', 'likes'])
            ->limit(5)
            ->get();

        $this->isActive = $this->user->status;
    }

    #[On('toggleActivateAccount')]
    public function toggleActivateAccount(): void
    {
        if ($this->isActive) {
            $this->deactivateAccount();

            return;
        }

        $this->activateAccount();
    }

    public function deactivateAccount(): void
    {
        $this->user->update(['status' => false]);
        $this->isActive = false;
        ToastMagic::success('حساب شما غیرفعال شد.');
    }

    public function activateAccount(): void
    {
        $this->user->update(['status' => true]);
        $this->isActive = true;
        ToastMagic::success('حساب شما فعال شد.');
    }

    #[On('deleteAccount')]
    public function deleteAccount(): ?RedirectResponse
    {
        try {
            DB::transaction(function () {
                $this->user->delete();
                Auth::logout();
            });

            ToastMagic::success(__('Account Deleted Successfully!'));

            return redirect()->route('home');

        } catch (Throwable $e) {
            report($e);
            ToastMagic::error(__('خطایی در حذف حساب رخ داد.'));
        }

        return null;
    }

    public function render()
    {
        return view('user::livewire.user.dashboard', [
            'contents' => $this->contents,
        ]);
    }
}
