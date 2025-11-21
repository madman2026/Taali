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
        $this->validate();

        $result = $this->service->create(
            payload: [
                'title' => $this->title,
                'excerpt' => $this->excerpt,
                'description' => $this->description,
                'user_id' => auth('web')->id(),
                'image_url' => $this->image,
                'audio_url' => $this->audio,
                'video_url' => $this->videoUrl,
            ]
        );
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
