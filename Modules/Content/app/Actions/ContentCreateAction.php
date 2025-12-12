<?php

namespace Modules\Content\Actions;

use Modules\Content\Enums\ContentStatus;
use Modules\Content\Enums\ContentStatusType;
use Modules\Content\Enums\ContentTypeEnum;
use Modules\Content\Events\ContentCreated;
use Modules\Content\Models\Content;
use Modules\Media\Enums\MediaTypeEnum;

class ContentCreateAction
{
    public function handle(array $payload): Content
    {
        $flags = [
            'image' => !empty($payload['image'] ?? null),
            'audio' => !empty($payload['audio'] ?? null),
            'video' => !empty($payload['videoUrl'] ?? null) || !empty($payload['videoHash'] ?? null),
        ];

        $activeTypes = array_filter($flags);

        $type = match(count($activeTypes)) {
            default => ContentTypeEnum::Post,
            0 => ContentTypeEnum::Article,
            1 => match (key($activeTypes)) {
                'image' => ContentTypeEnum::Photographic,
                'audio' => ContentTypeEnum::Podcast,
                'video' => ContentTypeEnum::Video,
            },
        };

        $content = Content::create([
            'title' => $payload['title'],
            'excerpt' => $payload['excerpt'],
            'description' => $payload['description'] ?? null,
            'user_id' => auth('web')->id(),
            'type' => $type->value,
        ]);

        $this->storeMedia($content, $payload);
        ContentCreated::dispatch($content);

        return $content->load(['user' , 'image' , 'audio']);
    }

    private function storeMedia(Content $content, array $payload): void
    {
        if (!empty($payload['image'])) {
            $content->media()->create([
                'type' => MediaTypeEnum::IMAGE,
                'path' => $payload['image'],
                'metadata' => ['original_url' => $payload['image']],
            ]);
        }

        if (!empty($payload['audio'])) {
            $content->media()->create([
                'type' => MediaTypeEnum::AUDIO,
                'path' => $payload['audio'],
                'metadata' => ['original_url' => $payload['audio']],
            ]);
        }

        if (!empty($payload['videoUrl'])) {
            $content->media()->create([
                'type' => MediaTypeEnum::VIDEO,
                'path' => $payload['videoUrl'],
                'metadata' => [
                    'original_url' => $payload['videoUrl'],
                    'service' => 'aparat'
                ],
            ]);
        }
    }
}
