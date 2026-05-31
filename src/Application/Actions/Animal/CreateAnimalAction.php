<?php

namespace App\Application\Actions\Animal;

use App\Application\Actions\Action;
use App\Domain\Animal\Animal;
use App\Domain\Animal\AnimalRepository;
use App\Domain\Animal\AnimalSex;
use App\Domain\Animal\AnimalStatus;
use Psr\Http\Message\ResponseInterface;
use Override;
use Psr\Log\LoggerInterface;

class CreateAnimalAction extends Action
{
    public function __construct(LoggerInterface $logger, private readonly AnimalRepository $animalRepository)
    {
        parent::__construct($logger);
    }

    #[Override]
    protected function action(): ResponseInterface
    {
        $body = (array) $this->getFormData();

        $farmId = trim($body['farm_id'] ?? '');
        $name = trim($body['name'] ?? '');
        $code = trim($body['code'] ?? '');
        $sex = trim($body['sex'] ?? '');
        $breed = trim($body['breed'] ?? '');
        $birthDate = trim($body['birth_date'] ?? '');
        $status = trim($body['status'] ?? AnimalStatus::ACTIVE->value);

        if (empty($farmId)) {
            return $this->respondWithData(['error' => 'Id da fazenda é obrigatório'], 422);
        }
        if (empty($name)) {
            return $this->respondWithData(['error' => 'Nome é obrigatório'], 422);
        }

        if (!in_array($sex, [AnimalSex::MALE->value, AnimalSex::FEMALE->value])) {
            return $this->respondWithData(['error' => 'Sexo inválido'], 422);
        }

        $animal = new Animal();
        $animal->farm_id = $farmId;
        $animal->name = $name;
        $animal->code = $code;
        $animal->sex = AnimalSex::from($sex);
        $animal->breed = $breed;
        $animal->birth_date = $birthDate;
        $animal->status = AnimalStatus::from($status);

        $this->animalRepository->save($animal);
        $this->logger->info(
            sprintf('Animal criado: %s (ID: %s)', $animal->name, $animal->id)
        );

        return $this->respondWithData($animal, 201);
    }
}
