<?php

namespace App\Domain\Animal;

use App\Domain\DomainException\DomainRecordNotFoundException;

class AnimalNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'Animal não encontrado.';
}
