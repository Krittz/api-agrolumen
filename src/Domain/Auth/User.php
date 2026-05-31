<?php
declare(strict_types=1);

namespace App\Domain\Auth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasUuids;

    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden   = ['password'];
}