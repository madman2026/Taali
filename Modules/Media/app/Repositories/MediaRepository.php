<?php

namespace Modules\Media\Repositories;

use App\Contracts\BaseRepository;
use App\Contracts\DTO;
use Modules\Content\Models\Content;
use Modules\Media\Models\Media;

class MediaRepository extends BaseRepository
{
    protected $model = Media::class;

    public function getByType($type)
    {
        return $this->model->whereType($type)->get();
    }

    public function updateOrCreateForContent(array|string $parametersForSearch, Content $content, DTO $data)
    {
        return $content->media()->updateOrCreate($parametersForSearch, $data->toArray());
    }
}
