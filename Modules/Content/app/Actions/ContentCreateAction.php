<?php

namespace Modules\Content\Actions;

use App\Contracts\DTO;
use App\Contracts\Facades\DTO as DTOFacade;
use Illuminate\Support\Facades\Log;
use Modules\Content\Enums\ContentTypeEnum;
use Modules\Content\Models\Content;
use Modules\Content\Repositories\ContentRepository;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Media\Repositories\MediaRepository;

class ContentCreateAction
{
    public function handle(DTO $payload, ContentRepository $repository, MediaRepository $mediaRepository): Content
    {
        // 1. Determine Content Type
        $flags = [
            'image' => ! empty($payload->image ?? null),
            'audio' => ! empty($payload->audio ?? null),
            'video' => ! empty($payload->videoUrl ?? null) || ! empty($payload->videoHash ?? null),
        ];

        $activeTypes = array_filter($flags); // Filter out empty values

        // 2. Determine Content Type based on active media types
        $type = match (count($activeTypes)) {
            0 => ContentTypeEnum::Article, // If no media, default to Article
            1 => match (key($activeTypes)) {
                'image' => ContentTypeEnum::Photographic,
                'audio' => ContentTypeEnum::Podcast,
                'video' => ContentTypeEnum::Video,
            },
            default => ContentTypeEnum::Post, // If multiple media types, default to Post
        };

        // 3. Prepare Payload for Repository
        unset($payload->image);
        unset($payload->audio);
        unset($payload->video);
        $payload->type = $type;

        // 4. Create Content
        $content = $repository->create($payload);

        // 5. Store Media
        $this->storeMedia($content, $payload->toArray(), $mediaRepository);

        // 6. Load Relationships
        return $content->load(['user', 'image', 'audio']);
    }

    private function storeMedia(Content $content, array $payload, MediaRepository $repository): void
    {
        // 1. Image
        if (! empty($payload['image'])) {
            try {
                $repository->updateOrCreateForContent(['type' => MediaTypeEnum::IMAGE], $content, DTOFacade::tryFrom([
                    'type' => MediaTypeEnum::IMAGE,
                    'path' => $payload['image'],
                    'metadata' => ['original_url' => $payload['image']],
                ]));
            } catch (\Exception $e) {
                // Log the error and potentially re-throw or handle gracefully
                Log::error('Error storing image: '.$e->getMessage());
            }
        }

        // 2. Audio
        if (! empty($payload['audio'])) {
            try {
                $repository->updateOrCreateForContent(['type' => MediaTypeEnum::AUDIO], $content, DTOFacade::tryFrom([
                    'type' => MediaTypeEnum::AUDIO,
                    'path' => $payload['audio'],
                    'metadata' => ['original_url' => $payload['audio']],
                ]));
            } catch (\Exception $e) {
                // Log the error
                Log::error('Error storing audio: '.$e->getMessage());
            }
        }

        // 3. Video
        if (! empty($payload['videoUrl'])) {
            try {
                $repository->updateOrCreateForContent(['type' => MediaTypeEnum::VIDEO], $content, DTOFacade::tryFrom([
                    'type' => MediaTypeEnum::VIDEO,
                    'path' => $payload['videoUrl'],
                    'metadata' => [
                        'original_url' => $payload['videoUrl'],
                        'service' => 'aparat',
                    ],
                ]));
            } catch (\Exception $e) {
                // Log the error
                Log::error('Error storing video: '.$e->getMessage());
            }
        }
    }
}
