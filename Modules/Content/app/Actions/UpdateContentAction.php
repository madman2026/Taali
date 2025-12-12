<?php

namespace Modules\Content\Actions;

use App\Contracts\HasAparatUrl;
use Illuminate\Support\Facades\Storage;
use Modules\Content\Events\ContentCreated;
use Modules\Content\Models\Content;
use Modules\Content\Enums\ContentStatusEnum;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\Content\Listeners\ProcessContentMedia;

class UpdateContentAction
{
    use HasAparatUrl;

    public function handle(Content $content, array $data): Content
    {
        // ---------------------------
        // 1) Update text fields
        // ---------------------------
        $content->fill([
            'title'       => $data['title'] ?? $content->title,
            'excerpt'     => $data['excerpt'] ?? $content->excerpt,
            'description' => $data['description'] ?? $content->description,
        ]);
        $content->save();

        // ---------------------------
        // 2) Handle media
        // ---------------------------
        // IMAGE
        if (!empty($data['image'])) {
            $path = $data['image']->store('contents/images/' . now()->format('Ymd'), 'public');
            $content->media()->updateOrCreate(
                ['type' => MediaTypeEnum::IMAGE->value],
                [
                    'path'   => $path,
                    'disk'   => 'public',
                    'status' => ContentStatusEnum::PROCCESSING->value,
                ]
            );
        }

        // AUDIO
        if (!empty($data['audio'])) {
            $path = $data['audio']->store('contents/audios/' . now()->format('Ymd'), 'public');
            $content->media()->updateOrCreate(
                ['type' => MediaTypeEnum::AUDIO->value],
                [
                    'path'   => $path,
                    'disk'   => 'public',
                    'status' => ContentStatusEnum::PROCCESSING->value,
                ]
            );
        }

        // VIDEO / Aparat
        if (array_key_exists('videoUrl', $data)) {
            $hash = $data['videoUrl'] ? $this->extractAparatHash($data['videoUrl']) : null;
            $content->media()->updateOrCreate(
                ['type' => MediaTypeEnum::VIDEO->value],
                [
                    'path'     => $hash,
                    'status'   => ContentStatusEnum::PROCCESSING->value,
                    'metadata' => $hash ? ['service' => 'aparat'] : null,
                ]
            );
        }

        // ---------------------------
        // 3) Dispatch listener/job
        // ---------------------------
        ContentCreated::dispatch($content->load('media'));

        return $content->load('media');
    }
}
