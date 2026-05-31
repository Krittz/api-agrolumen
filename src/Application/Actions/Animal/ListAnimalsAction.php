<?php

namespace App\Application\Actions\Animal;

use App\Application\Actions\Action;
use App\Domain\Animal\AnimalRepository;
use Psr\Log\LoggerInterface;
use Override;
use Psr\Http\Message\ResponseInterface;

class ListAnimalsAction extends Action
{
    #[Override]
    public function __construct(LoggerInterface $logger, private readonly AnimalRepository $animalRepository)
    {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $farmId = $this->resolveArg('farm_id');
        return $this->respondWithData($this->animalRepository->findByFarm($farmId));
    }
}
