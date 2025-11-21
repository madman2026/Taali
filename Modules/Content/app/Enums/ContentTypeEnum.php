<?php

namespace Modules\Content\Enums;

enum ContentTypeEnum: string
{
    case Article = 'article';
    case Podcast = 'podcast';
    case Video = 'video';
    case Photographic = 'photographic';
    case Post = 'post';
}
