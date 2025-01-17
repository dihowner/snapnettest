<?php

namespace App\Enums;

enum ProjectStatusEnum: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Inactive = 'inactive';
    case Closed = 'closed';
}
