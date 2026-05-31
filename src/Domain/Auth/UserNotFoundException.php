<?php

namespace App\Domain\Auth;

use App\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'Usuário não encontrado.';
}
