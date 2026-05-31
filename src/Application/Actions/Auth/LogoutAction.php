<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Application\Support\CookieFactory;
use App\Domain\Auth\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class LogoutAction extends Action
{
    public function __construct(LoggerInterface $logger, private readonly UserRepository $userRepository)
    {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $cookies = $this->request->getCookieParams();
        $token = $cookies['session_token'] ?? null;

        if ($token === null) {
            return $this->respondWithData(['error' => 'Não autenticado.'], 401);
        }

        $this->userRepository->deleteSession($token);

        $this->logger->info('Logout realizado.');

        return $this->respondWithData(['message' => 'Sessão encerrada com sucesso.'])
            ->withAddedHeader('Set-Cookie', CookieFactory::destroy());
    }
}
