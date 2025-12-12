<?php

namespace Modules\Content\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Modules\Content\Services\ContentService;

#[Layout('components.layouts.master')]
#[Title('Content Create')]
class ContentCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('required|string|max:1000')]
    public $excerpt;

    #[Validate('nullable|string')]
    public $description;

    #[Validate('nullable|image|max:10000')]
    public $image;

    #[Validate('nullable|file|mimetypes:audio/*|max:30000')]
    public $audio;

    #[Validate('nullable|url|max:500')]
    public $videoUrl;

    public $videoHash;

    protected ContentService $service;

    public function boot(ContentService $service)
    {
        $this->service = $service;
    }

    public function updatedVideoUrl()
    {
        preg_match('/(videohash\/|v\/)([a-zA-Z0-9]+)/', $this->videoUrl, $matches);

        if (isset($matches[2])) {
            $this->videoHash = $matches[2];
        }
    }

    public function save()
    {
        $data = $this->validate();
        if ($this->image)
        {
            $data['image'] = $this->image->store('contents/images');
        }

        if ($this->audio)
        {
            $data['audio'] = $this->audio->store('contents/audios');
        }
        if ($this->videoUrl)
        {
            $data['videoUrl'] = $this->videoHash;
        }
        $result = $this->service->create($data);

        if ($result->status){
            ToastMagic::success(__('Content created and queued for processing!'));
            return $this->redirectRoute('content.index');

        }else{
            ToastMagic::error(__('Something Wen Wrong!'));
        }
    }

    public function render()
    {
        return view('content::livewire.content-create');
    }
}
