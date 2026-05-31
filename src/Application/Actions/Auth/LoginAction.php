<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Application\Support\CookieFactory;
use App\Domain\Auth\Session;
use App\Domain\Auth\UserRepository;
use Carbon\Carbon;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class LoginAction extends Action
{
    public function __construct(LoggerInterface $logger, private readonly UserRepository $userRepository)
    {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $body     = (array) $this->getFormData();
        $email    = trim($body['email'] ?? '');
        $password = $body['password'] ?? '';

        if ($email === '' || $password === '') {
            return $this->respondWithData(['error' => 'email e password são obrigatórios.'], 422);
        }

        $user = $this->userRepository->findByEmail($email);

        if ($user === null || !password_verify($password, $user->password)) {
            return $this->respondWithData(['error' => 'Credenciais inválidas.'], 401);
        }

        $session             = new Session();
        $session->user_id    = $user->id;
        $session->token      = bin2hex(random_bytes(40));
        $session->expires_at = Carbon::now()->addDays(7);

        $this->userRepository->saveSession($session);

        $this->logger->info("Login: {$user->email}");

        return $this->respondWithData(['expires_at' => $session->expires_at])
            ->withAddedHeader(
                'Set-Cookie',
                CookieFactory::session($session->token)
            );
    }
}
