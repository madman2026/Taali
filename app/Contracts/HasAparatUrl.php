<?php

namespace App\Contracts;

trait HasAparatUrl
{
    public function extractAparatHash(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $url = trim($url);

        /**
         * Supported formats:
         *  - https://www.aparat.com/v/XXXXXXX
         *  - https://aparat.com/v/XXXXXXX
         *  - https://www.aparat.com/video/video/embed/videohash/XXXXXXX/vt/frame
         *  - https://aparat.com/video/video/embed/videohash/XXXXXXX
         *  - https://www.aparat.com/video/video/embed/videohash/XXXXXXX/some/extra
         *  - iframe src formats
         */

        // 1) direct video hash: /v/{hash}
        if (preg_match('#aparat\.com\/v\/([A-Za-z0-9]+)#', $url, $m)) {
            return $m[1];
        }

        // 2) embed format: videohash/{hash}
        if (preg_match('#videohash\/([A-Za-z0-9]+)#', $url, $m)) {
            return $m[1];
        }

        // 3) check inside iframe HTML
        if (preg_match('#src="https:\/\/www\.aparat\.com\/video\/video\/embed\/videohash\/([A-Za-z0-9]+)#', $url, $m)) {
            return $m[1];
        }

        // 4) extremely raw last fallback: find tokens of length 5–12
        if (preg_match('#aparat\.com\/(?:video\/)?([A-Za-z0-9]{5,12})#', $url, $m)) {
            return $m[1];
        }

        return null;
    }

}
