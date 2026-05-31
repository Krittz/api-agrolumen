<?php

namespace App\Domain\Farm;

interface FarmRepository
{
    /** @return Farm[] */
    public function findByUser(string $userId): array;
    public function saveWithOwner(Farm $farm, string $userId): void;
    
}
