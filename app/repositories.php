<?php

declare(strict_types=1);

use App\Domain\Animal\AnimalRepository;
use App\Domain\Auth\UserRepository;
use App\Domain\Farm\FarmRepository;
use App\Infrastructure\Persistence\Animal\EloquentAnimalRepository;
use App\Infrastructure\Persistence\Auth\EloquentUserRepository;
use App\Infrastructure\Persistence\Farm\EloquentFarmRepository;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => function (ContainerInterface $c) {
            $c->get(Capsule::class);
            return new EloquentUserRepository();
        },

        FarmRepository::class => function (ContainerInterface $c) {
            $c->get(Capsule::class);
            return new EloquentFarmRepository();
        },

        AnimalRepository::class => function (ContainerInterface $c) {
            $c->get(Capsule::class);
            return new EloquentAnimalRepository();
        },
    ]);
};
