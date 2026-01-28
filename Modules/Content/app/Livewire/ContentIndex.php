<?php

namespace Modules\Content\Livewire;

use App\Contracts\HasNotifableComponent;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Content\Enums\ContentStatusEnum;
use Modules\Content\Models\Content;

#[Layout('components.layouts.master')]
#[Title('Content List')]
class ContentIndex extends Component
{
    use HasNotifableComponent;
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $search = '';

    public string $type = 'all';

    // IMPROVED: Using 'as' for cleaner URLs (e.g., ?q=... instead of ?search=...)
    protected $queryString = [
        'search' => ['as' => 'q', 'except' => ''],
        'type' => ['except' => 'all'],
    ];

    /* -------------------------
        Lifecycle Hooks
    --------------------------*/

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingType(): void
    {
        $this->resetPage();
    }

    /* -------------------------
        Actions
    --------------------------*/

    public function deleteContent(int $id): void
    {
        $content = Content::findOrFail($id);

        Gate::authorize('delete.content', $content);

        $content->delete();

        // REMOVED: $this->resetPage() for better UX. Livewire will handle the view refresh correctly.
        $this->success('محتوا با موفقیت حذف شد.');
    }

    public function approveContent(int $id): void
    {
        $content = Content::findOrFail($id);

        Gate::authorize('approve.content', $content);

        if ($content->status === ContentStatusEnum::APPROVED) {
            $this->warning('این محتوا قبلاً تائید شده است.');

            return;
        }

        $content->update([
            'status' => ContentStatusEnum::APPROVED,
            'published_at' => now(),
        ]);

        $this->success('محتوا با موفقیت تائید و منتشر شد.');
    }

    // ADDED: The missing rejectContent method.
    public function rejectContent(int $id): void
    {
        $content = Content::findOrFail($id);

        Gate::authorize('approve.content', $content); // Assuming same permission as approve

        if ($content->status === ContentStatusEnum::REJECTED) {
            $this->warning('این محتوا قبلاً رد شده است.');

            return;
        }

        $content->update(['status' => ContentStatusEnum::REJECTED]);

        $this->success('محتوا با موفقیت رد شد.');
    }

    /* -------------------------
        Computed Properties & Data
    --------------------------*/

    public function getContentsProperty()
    {
        return $this->buildContentQuery()->paginate(10);
    }

    // ADDED: Extracted query builder for better readability and maintenance.
    private function buildContentQuery(): Builder
    {
        return Content::query()
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%")
                        // IMPROVED: Added excerpt to search query to match the placeholder
                        ->orWhere('excerpt', 'like', "%{$this->search}%");
                });
            })
            ->when($this->type !== 'all', fn (Builder $q) => $q->where('type', $this->type))
            // IMPROVED: Removed 'media' as it's not a relationship based on the view. 'user' is kept.
            ->with(['user'])
            ->withCount(['comments', 'likes', 'views'])
            ->latest('id');
    }

    /* -------------------------
        Render
    --------------------------*/

    public function render(): View
    {
        return view('content::livewire.content-index', [
            'contents' => $this->contents,
        ]);
    }
}
