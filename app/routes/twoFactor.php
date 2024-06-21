<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\twoFactorController;
use App\Middleware\AuthJwt;

return function ($app) {
    session_start();

    // Rotas protegidas com JWT
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->post('/2FA/user/{id}', TwoFactorController::class . ':twoFactor');
    })->add(new AuthJwt());
};