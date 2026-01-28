<?php

namespace Modules\Content\Repositories;

use App\Contracts\BaseRepository;
use Modules\Content\Models\Content;

class ContentRepository extends BaseRepository
{
    protected $model = Content::class;

    public function findBySlug(string $slug)
    {
        return $this->model->whereSlug($slug)->withCount(['likes', 'views', 'comments.children'])->with(['comments.children.parent', 'users'])->first();
    }
}
