<?php

namespace Modules\Content\Livewire;

use App\Contracts\HasNotifableComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Content\Models\Content;

#[Layout('components.layouts.master')]
#[Title('Content List')]
class ContentIndex extends Component
{
    use WithPagination , HasNotifableComponent;

    public string $search = '';

    public string $type = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        $this->success('محتوا با موفقیت حذف شد.');
    }

    public function getContentsProperty()
    {
        return Content::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('slug', 'like', "%{$this->search}%")
            )
            ->when($this->type !== 'all', fn ($q) => $q->where('type', $this->type)
            )
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('content::livewire.content-index', [
            'contents' => $this->contents,
        ]);
    }
}
