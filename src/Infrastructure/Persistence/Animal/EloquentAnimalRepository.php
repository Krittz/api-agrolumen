<?php

namespace App\Infrastructure\Persistence\Animal;

use App\Domain\Animal\Animal;
use App\Domain\Animal\AnimalRepository;
use Override;

class EloquentAnimalRepository implements AnimalRepository
{
    #[Override]
    public function save(Animal $animal): void
    {
        $animal->save();
    }

    public function findById(string $id): ?Animal
    {
        return Animal::find($id);
    }

    #[Override]
    public function findByFarmAndCode(string $farmId, string $code): ?Animal
    {
        return Animal::query()
            ->where('farm_id', $farmId)
            ->where('code', $code)
            ->first();
    }

    public function findByFarm(string $farmId): array
    {
        return Animal::query()
            ->where('farm_id', $farmId)
            ->orderBy('code')
            ->get()
            ->all();
    }
}
