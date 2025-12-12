<?php

namespace Modules\Content\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Content\Models\Content;

class ContentCreated
{
    use Dispatchable, SerializesModels;

    public $content;

    public function __construct(Content $content)
    {
        $this->content = $content;
    }
}
