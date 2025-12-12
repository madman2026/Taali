<?php

namespace Modules\Content\Listeners;

use getID3;
use getid3_lib;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProcessContentMedia implements ShouldQueue
{
    protected $disk;

    protected $imageManager;

    public function __construct()
    {
        $this->disk = Storage::disk('public');
        $this->imageManager = new ImageManager(extension_loaded('imagick') ? 'imagick' : 'gd');
    }

    public function handle($content)
    {
        $content->load('media');

        foreach ($content->media as $media) {
            try {
                switch ($media->type) {
                    case 'image':
                        $this->processImageMedia($media);
                        break;
                    case 'audio':
                        $this->processAudioMedia($media);
                        break;
                    case 'video':
                        $this->processVideoMedia($media);
                        break;
                }
                $media->status = \Modules\Content\Enums\ContentStatusEnum::PROCCESSED->value;
            } catch (\Throwable $e) {
                Log::error("Media processing failed for {$media->type}: ".$e->getMessage());
                $media->status = \Modules\Content\Enums\ContentStatusEnum::FAILED->value;
            }
            $media->save();
        }
    }

    protected function processImageMedia($media)
    {
        if (! $this->disk->exists($media->path)) {
            throw new \Exception("Image not found: {$media->path}");
        }

        $img = $this->imageManager->make($this->disk->get($media->path));

        // Resize if too large
        if ($img->width() > 3840 || $img->height() > 2160) {
            $img->resize(3840, 2160, fn ($c) => $c->aspectRatio()->upsize());
        }

        // Encode & save optimized
        $encoded = $img->encode('jpg', 80);
        $this->disk->put($media->path, (string) $encoded);

        // Create thumbnail
        $thumbPath = dirname($media->path).'/thumb_'.basename($media->path);
        $thumb = $this->imageManager->make($this->disk->get($media->path))->fit(300, 300)->encode('jpg', 75);
        $this->disk->put($thumbPath, (string) $thumb);

        $media->metadata = [
            'width' => $img->width(),
            'height' => $img->height(),
            'thumbnail' => $thumbPath,
        ];
    }

    protected function processAudioMedia($media)
    {
        if (! $this->disk->exists($media->path)) {
            throw new \Exception("Audio not found: {$media->path}");
        }

        $tmp = tempnam(sys_get_temp_dir(), 'aud_');
        file_put_contents($tmp, $this->disk->get($media->path));

        $getID3 = new getID3;
        $info = $getID3->analyze($tmp);
        getid3_lib::CopyTagsToComments($info);

        $duration = $info['playtime_seconds'] ?? null;
        $bitrate = $info['audio']['bitrate'] ?? null;
        $sample = $info['audio']['sample_rate'] ?? null;

        // Re-encode audio
        try {
            $finalPath = $media->path; // overwrite original
            FFMpeg::fromDisk('public')
                ->open($media->path)
                ->export()
                ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                ->save($finalPath);
        } catch (\Throwable $e) {
            Log::warning('FFMpeg failed, keeping original: '.$e->getMessage());
        }

        $media->metadata = [
            'duration' => $duration,
            'bitrate' => $bitrate,
            'sample' => $sample,
            'size' => $this->disk->size($media->path),
        ];
    }

    protected function processVideoMedia($media)
    {
        // For Aparat: only the hash is stored; you can fetch metadata if needed
        if (! empty($media->path)) {
            $media->metadata = [
                'service' => 'aparat',
                'hash' => $media->path,
            ];
        } else {
            throw new \Exception('Video hash is missing');
        }
    }
}
