<?php

namespace Modules\Content\Enums;

enum ContentStatusEnum: string
{
    case APPROVED = 'approved';
    case PROCESSED = 'processed';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case FAILED = 'failed';
}
