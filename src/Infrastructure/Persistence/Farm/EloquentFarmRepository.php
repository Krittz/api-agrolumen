<?php

namespace App\Infrastructure\Persistence\Farm;

use App\Domain\Farm\Farm;
use App\Domain\Farm\FarmRepository;
use App\Domain\Farm\Membership;
use App\Domain\Farm\MembershipRole;
use Illuminate\Database\Capsule\Manager as Capsule;
use Override;

class EloquentFarmRepository implements FarmRepository
{

    #[Override]
    public function findByUser(string $userId): array
    {
        return Farm::query()
            ->join('memberships', 'memberships.farm_id', '=', 'farms.id')
            ->where('memberships.user_id', $userId)
            ->select('farms.*')
            ->get()
            ->toArray();
    }

    #[Override]
    public function saveWithOwner(Farm $farm, string $userId): void
    {
        Capsule::transaction(function () use ($farm, $userId) {
            $farm->save();

            $membership = new Membership();
            $membership->user_id = $userId;
            $membership->farm_id = $farm->id;
            $membership->role = MembershipRole::OWNER;
            $membership->save();
        });
    }
}
