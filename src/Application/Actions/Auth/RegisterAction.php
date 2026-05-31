<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\Auth\User;
use App\Domain\Auth\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class RegisterAction extends Action
{
    public function __construct(LoggerInterface $logger, private readonly UserRepository $userRepository,)
    {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $body = (array) $this->getFormData();

        $name     = trim($body['name'] ?? '');
        $email    = trim($body['email'] ?? '');
        $password = $body['password'] ?? '';

        if ($name === '' || $email === '' || $password === '') {
            return $this->respondWithData(['error' => 'name, email e password são obrigatórios.'], 422);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->respondWithData(['error' => 'Email inválido.'], 422);
        }

        if ($this->userRepository->findByEmail($email) !== null) {
            return $this->respondWithData(['error' => 'Email já cadastrado.'], 422);
        }

        $user           = new User();
        $user->name     = $name;
        $user->email    = $email;
        $user->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 14]);

        $this->userRepository->save($user);

        $this->logger->info("Novo usuário registrado: {$user->email}");

        return $this->respondWithData($user, 201);
    }
}
