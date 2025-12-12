<?php

namespace Modules\Content\Enums;

enum ContentStatusEnum: string
{
    case PROCCESSING='proccessing';
    case PROCCESSED='proccessed';
    case FAILED='failed';
    case REJECTED='rejected';
}
