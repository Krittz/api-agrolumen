<?php

declare(strict_types=1);

namespace App\Domain\Animal;

enum AnimalStatus: string
{
    case ACTIVE = 'ACTIVE';
    case SOLD = 'SOLD';
    case DEAD = 'DEAD';
    case DISCARDED = 'DISCARDED';
}
