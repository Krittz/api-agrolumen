<?php
declare(strict_types=1);

namespace App\Domain\Auth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasUuids;

    protected $table = 'sessions';
    protected $keyType = 'string';
    public $incrementing = false;

    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'token', 'expires_at'];
    protected $casts    = ['expires_at' => 'datetime'];
}