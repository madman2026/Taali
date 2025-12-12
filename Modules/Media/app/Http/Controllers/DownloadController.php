<?php

namespace Modules\Media\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Models\Media;

class DownloadController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Link expired');
        }

        $media = Media::findOrFail($id);
        $disk = $media->disk;

        if (! Storage::disk($disk)->exists($media->path)) {
            abort(404);
        }

        $stream = Storage::disk($disk)->readStream($media->path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $media->mime_type,
            'Content-Length' => $media->size,
            'Content-Disposition' => 'inline; filename="'.$media->name.'"',
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
