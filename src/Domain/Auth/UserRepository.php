<?php

namespace App\Domain\Auth;

interface UserRepository
{
    public function findByEmail(string $email): ?User;
    public function findById(string $id): ?User;
    public function save(User $user): void;
    public function saveSession(Session $session): void;
    public function findSessionByToken(string $token): ?Session;
    public function deleteSession(string $token): void;
}
