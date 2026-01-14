<?php

namespace Modules\Media\Enums;

enum MediaStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSED = 'processed';
    case FAILED = 'failed';
    case REJECTED = 'rejected';
}
