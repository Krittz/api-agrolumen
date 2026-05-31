<?php
declare(strict_types=1);

namespace App\Domain\Farm;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Membership extends Model
{
    use HasUuids;

    protected $table = 'memberships';
    protected $keyType = 'string';
    public $incrementing = false;

    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'farm_id', 'role'];
    protected $casts = [
        'role' => MembershipRole::class,
    ];
}