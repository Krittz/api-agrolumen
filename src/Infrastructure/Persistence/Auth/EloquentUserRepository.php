<?php

namespace App\Infrastructure\Persistence\Auth;

use App\Domain\Auth\Session;
use App\Domain\Auth\User;
use App\Domain\Auth\UserRepository;
use Override;

class EloquentUserRepository implements UserRepository
{
    #[Override]
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    #[Override]
    public function findById(string $id): ?User
    {
        return User::find($id);
    }

    #[Override]
    public function save(User $user): void
    {
        $user->save();
    }

    #[Override]
    public function saveSession(Session $session): void
    {
        $session->save();
    }

    #[Override]
    public function findSessionByToken(string $token): ?Session
    {
        return Session::where('token', $token)->first();
    }

    #[Override]
    public function deleteSession(string $token): void
    {
        Session::where('token', $token)->delete();
    }
}
