<?php

namespace Modules\Interaction\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\User\Models\User;

class InteractService
{
    public function __construct(public Model $interactable, public ?User $user = null) {}

    public function visit()
    {
        if (
            auth()->check() &&
            $this->interactable->views()
                ->where('user_id', $this->user?->id ?? auth()->id())
                ->exists()
        ) {
            return $this;
        }

        $this->interactable->views()->create([
            'ip_address' => request()->ip(),
            'user_id' => $this->user?->id ?? auth()?->id() ?: null,
        ]);

        return $this;

    }

    public function toggleLike()
    {
        $like = $this->interactable->likes()
            ->where('user_id', $this->user?->id ?? Auth::id())
            ->first();
        if ($like) {
            $like->delete();

            return $this;
        }

        $this->interactable->likes()->create([
            'ip_address' => request()->ip(),
            'user_id' => $this->user?->id ?? Auth::id(),
        ]);

        return $this;
    }
}
