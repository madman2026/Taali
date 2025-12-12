<?php

namespace Modules\Content\Livewire;

use App\Contracts\HasAparatUrl;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Content\Models\Content;
use Modules\Content\Services\ContentService;

class ContentUpdate extends Component
{
    use WithFileUploads, HasAparatUrl;

    public Content $content;
    protected ContentService $service;

    public $title;
    public $excerpt;
    public $description;
    public $videoUrl;
    public $image = null;
    public $audio = null;
    public $videoHash;

    public $currentImage;
    public $currentAudio;

    protected $rules = [
        'title' => 'required|string|max:255',
        'excerpt' => 'nullable|string|max:500',
        'description' => 'nullable|string',
        'videoUrl' => 'nullable|url',
        'image' => 'nullable|image|max:2048',      // 2MB max
        'audio' => 'nullable|mimes:mp3,wav|max:10000', // 5MB max
    ];

    public function mount(Content $Content)
    {
        $this->content = $Content;

        $this->title = $Content->title;
        $this->excerpt = $Content->excerpt;
        $this->description = $Content->description;
        $this->videoUrl = 'https://www.aparat.com/v/'.$Content->video->path;

        $this->currentImage = $Content->image?->temporary_url;
        $this->currentAudio = $Content->audio?->temporary_url;

        $this->videoHash = $this->extractAparatHash($this->videoUrl);
    }

    public function boot(ContentService $service)
    {
        $this->service = $service;
    }

    public function updated($property)
    {
        $this->validateOnly($property);
        if ($property == 'videoUrl')
        {
            $this->videoHash = $this->extractAparatHash($this->videoUrl);
        }

    }

    public function update()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'description' => $this->description,
            'videoUrl' => $this->videoUrl,
            'image' => $this->image,
            'audio' => $this->audio,
        ];

        // آپدیت از طریق سرویس
        $result = $this->service->update($this->content, $data);

        if ($result->status ?? false) {
            $this->dispatch('toastMagic', status:'success', title:'انجام شد!', message:'در صف پردازش قرار گرفت!');
        } else {
            $this->dispatch('toastMagic', status:'error', title:'خطا!', message:'مشکلی پیش آمد!');
        }


        return $this->redirectRoute('home');
    }

    public function render()
    {
        return view('content::livewire.content-update');
    }
}
