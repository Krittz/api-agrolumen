<?php

namespace App\Domain\Animal;

use DomainException;

class AnimalCodeAlreadyExistsException extends DomainException
{
    protected $message = 'Já existe um animal com este código na fazenda.';
}
