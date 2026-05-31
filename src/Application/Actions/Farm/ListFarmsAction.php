<?php

declare(strict_types=1);

namespace App\Application\Actions\Farm;

use App\Application\Actions\Action;
use App\Domain\Farm\FarmRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ListFarmsAction extends Action
{
    public function __construct(LoggerInterface $logger, private readonly FarmRepository $farmRepository)
    {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $userId = $this->request->getAttribute('user_id');

        return $this->respondWithData(
            $this->farmRepository->findByUser($userId)
        );
    }
}
