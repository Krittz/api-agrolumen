<?php

declare(strict_types=1);

namespace App\Application\Actions\Farm;

use App\Application\Actions\Action;
use App\Domain\Farm\Farm;
use App\Domain\Farm\FarmData;
use App\Domain\Farm\FarmRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class CreateFarmAction extends Action
{
    public function __construct(LoggerInterface $logger, private readonly FarmRepository $farmRepository)
    {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $body   = (array) $this->getFormData();
        $userId = $this->request->getAttribute('user_id');

        $name = trim($body['name'] ?? '');

        if ($name === '') {
            return $this->respondWithData(['error' => 'name é obrigatório.'], 422);
        }

        $farm              = new Farm();
        $farm->name        = $name;
        $farm->description = trim($body['description'] ?? '');

        $this->farmRepository->saveWithOwner($farm, $userId);

        $this->logger->info("Fazenda criada: {$farm->name} por usuário {$userId}");

        return $this->respondWithData(FarmData::fromModel($farm), 201);
    }
}
