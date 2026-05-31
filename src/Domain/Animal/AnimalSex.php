<?php

declare(strict_types=1);

namespace App\Domain\Animal;

enum AnimalSex: string
{
    case MALE = 'MALE';
    case FEMALE = 'FEMALE';
}
