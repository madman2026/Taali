<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Modules\Content\Models\Content;
use Modules\Interaction\Models\Comment;
use Modules\Interaction\Services\InteractService;

trait InteractableComponent
{
    protected Model|Content $interactable;

    protected function createComment($body, $ip_address, $user_id)
    {
        $this->interactable->comments()->create([
            'ip_address' => $ip_address,
            'body' => $body,
            'user_id' => $user_id,
        ]);

        $this->success('comment created!');
    }

    protected function updateComment(Comment $comment, string $body, $ip_address)
    {
        $comment->update([
            'body' => $body,
            'ip_address' => $ip_address,
        ]);

        $this->success('comment updated!');
    }

    protected function act()
    {
        return app(InteractService::class, [
            'interactable' => $this->interactable,
        ]);
    }
}
