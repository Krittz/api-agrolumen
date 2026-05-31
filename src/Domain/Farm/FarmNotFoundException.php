<?php

namespace App\Domain\Farm;

use App\Domain\DomainException\DomainRecordNotFoundException;

class FarmNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'Fazenda não encontrada.';
}
