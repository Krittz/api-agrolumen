<?php

declare(strict_types=1);

use App\Application\Actions\Animal\CreateAnimalAction;
use App\Application\Actions\Animal\ListAnimalsAction;
use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Auth\LogoutAction;
use App\Application\Actions\Auth\RegisterAction;
use App\Application\Actions\Farm\CreateFarmAction;
use App\Application\Actions\Farm\ListFarmsAction;
use App\Application\Middleware\AuthMiddleware;
use Carbon\Carbon;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/health', function (Request $request, Response $response) {
        $response->getBody()->write(
            json_encode([
                'status' => 'Healthy',
                'timestamp' => Carbon::now()->format('d/m/Y H:i:s')
            ])
        );
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->group('/api', function (Group $api) {
        // Público
        $api->post('/auth/register', RegisterAction::class);
        $api->post('/auth/login',    LoginAction::class);

        // Protegido
        $api->group('', function (Group $protected) {
            // Fazendas
            $protected->post('/auth/logout',  LogoutAction::class);
            $protected->post('/farms',        CreateFarmAction::class);
            $protected->get('/farms',         ListFarmsAction::class);

            // Animais
            $protected->post('/animals',                CreateAnimalAction::class);
            $protected->get('/farms/{farm_id}/animals', ListAnimalsAction::class);
        })->add(AuthMiddleware::class);
    });
};
