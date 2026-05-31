<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\Auth\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cookies = $request->getCookieParams();
        $token = $cookies['session_token'] ?? null;

        if ($token === null) {
            throw new HttpUnauthorizedException($request);
        }

        $session = $this->userRepository->findSessionByToken($token);

        if ($session === null || $session->expires_at->isPast()) {
            throw new HttpUnauthorizedException($request);
        }

        return $handler->handle(
            $request->withAttribute('user_id', $session->user_id)
        );
    }
}
