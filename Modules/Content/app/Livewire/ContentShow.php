<?php

namespace Modules\Content\Livewire;

use Livewire\Component;
use Modules\Content\Models\Content;

class ContentShow extends Component
{
    public Content $content;
    public function mount(Content $Content)
    {
        $this->content = $Content->load(['user' , 'comments' , 'image' , 'audio' , 'video'])->loadCount(['comments' , 'likes' , 'views']);
    }
    public function render()
    {
        return view('content::livewire.content-show');
    }
}
