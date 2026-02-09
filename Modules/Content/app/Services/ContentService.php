<?php

namespace Modules\Content\Services;

use App\Contracts\BaseService;
use App\Contracts\Facades\DTO;
use Modules\Content\Actions\ContentCreateAction;
use Modules\Content\Actions\UpdateContentAction;
use Modules\Content\Models\Content;
use Modules\Content\Repositories\ContentRepository;
use Modules\Media\Repositories\MediaRepository;

class ContentService extends BaseService
{
    public function __construct(private ContentRepository $repository, private MediaRepository $mediaRepository, private ContentCreateAction $createAction, private UpdateContentAction $updateAction) {}

    public function index()
    {
        return $this->execute(fn () => $this->repository->all());
    }

    public function get(Content $content)
    {
        return $this->execute(fn () => $this->repository->findBySlug($content->slug));
    }

    public function delete(Content $content)
    {
        return $this->execute(fn () => $this->repository->delete($content));
    }

    public function update(Content $content, array $data)
    {

        return $this->execute(fn () => $this->updateAction->handle($content, $data, $this->repository, $this->mediaRepository));
    }

    public function create(array $payload)
    {
        $payload = DTO::tryFrom([
            'title' => $payload['title'],
            'excerpt' => $payload['excerpt'],
            'description' => $payload['description'] ?? null,
            'user_id' => auth('web')->id(),
            'image' => $payload['image'] ?? null,
            'audio' => $payload['audio'] ?? null,
            'video' => $payload['videoUrl'] ?? null,
        ]);

        return $this->execute(fn () => $this->createAction->handle($payload, $this->repository, $this->mediaRepository));
    }
}
