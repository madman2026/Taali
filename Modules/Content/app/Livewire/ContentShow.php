<?php

namespace Modules\Content\Livewire;

use App\Contracts\InteractableComponent;
use Livewire\Component;
use Modules\Content\Models\Content;

class ContentShow extends Component
{
    use InteractableComponent;

    public Content $content;

    public function mount(Content $Content)
    {
        $this->content = $Content
            ->load(['user', 'comments', 'media'])
            ->loadCount(['comments', 'likes', 'views']);
        $this->interactable = $this->content;
        //        dd($this->content->media);

    }

    public function render()
    {
        return view('content::livewire.content-show');
    }
}
