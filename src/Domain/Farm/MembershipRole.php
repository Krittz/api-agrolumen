<?php

namespace App\Domain\Farm;

enum MembershipRole: string
{
    case OWNER = 'OWNER';
    case EDITOR = 'EDITOR';
    case VIEWER = 'VIEWER';
}
