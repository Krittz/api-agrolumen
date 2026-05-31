<?php

namespace App\Domain\Animal;


interface AnimalRepository
{
    public function save(Animal $animal): void;
    public function findById(string $id): ?Animal;
    public function findByFarmAndCode(string $farmId, string $code): ?Animal;

    /** @return Animal[] */
    public function findByFarm(string $farmId): array;
}
