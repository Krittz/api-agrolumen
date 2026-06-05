<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Monolog\Logger;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => getenv('APP_ENV') === 'production'
                        ? 'php://stdout'
                        : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'driver'    => 'mysql',
                    'host'      => $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: '127.0.0.1',
                    'port'      => $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '3306',
                    'database'  => $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?: '',
                    'username'  => $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: '',
                    'password'  => $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '',
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                ],
            ]);
        }
    ]);
};
