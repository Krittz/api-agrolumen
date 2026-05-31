<?php
declare(strict_types=1);

namespace App\Domain\Farm;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasUuids;

    protected $table = 'farms';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'description'];
}