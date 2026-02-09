<?php

namespace Modules\Content\Actions;

use App\Contracts\Facades\DTO;
use App\Contracts\HasAparatUrl;
use Modules\Content\Models\Content;
use Modules\Content\Repositories\ContentRepository;
use Modules\Media\Enums\MediaStatusEnum;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Repositories\MediaRepository;

class UpdateContentAction
{
    use HasAparatUrl;

    public function handle(Content $content, array $data, ContentRepository $repository, MediaRepository $mediaRepository): Content
    {
        $content->fill([
            'title' => $data['title'] ?? $content->title,
            'excerpt' => $data['excerpt'] ?? $content->excerpt,
            'description' => $data['description'] ?? $content->description,
        ]);
        $content->save();

        if (! empty($data['image'])) {
            $path = $data['image']->store('contents/images/'.now()->format('Ymd'), 'public');
            $mediaRepository->updateOrCreateForContent(
                ['type' => MediaTypeEnum::IMAGE],
                $content,
                DTO::tryFrom([
                    'path' => $path,
                    'disk' => 'public',
                    'status' => MediaStatusEnum::PENDING,
                ])
            );
        }

        if (! empty($data['audio'])) {
            $path = $data['audio']->store('contents/audios/'.now()->format('Ymd'), 'public');
            $mediaRepository->updateOrCreateForContent(
                ['type' => MediaTypeEnum::AUDIO],
                $content,
                DTO::tryFrom([
                    'path' => $path,
                    'disk' => 'public',
                    'status' => MediaStatusEnum::PENDING,
                ])
            );
        }

        if (array_key_exists('videoUrl', $data)) {
            $hash = $data['videoUrl'] ? $this->extractAparatHash($data['videoUrl']) : null;
            $mediaRepository->updateOrCreateForContent(
                ['type' => MediaTypeEnum::VIDEO],
                $content,
                DTO::tryFrom([
                    'path' => $hash,
                    'status' => MediaStatusEnum::PENDING,
                    'metadata' => $hash ? ['service' => 'aparat'] : null,
                ])
            );
        }
        $content->load('media');

        return $content;
    }
}
