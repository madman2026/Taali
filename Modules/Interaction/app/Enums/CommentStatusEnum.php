<?php

namespace Modules\Interaction\Enums;

enum CommentStatusEnum: string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PENDING = 'pending';
}
