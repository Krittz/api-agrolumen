<?php

declare(strict_types=1);

namespace App\Domain\Animal;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasUuids;

    protected $table = 'animals';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'farm_id',
        'code',
        'name',
        'sex',
        'breed',
        'birth_date',
        'status',
    ];

    protected $casts = [
        'sex' => AnimalSex::class,
        'status' => AnimalStatus::class,
        'birth_date' => 'date',
    ];
}
