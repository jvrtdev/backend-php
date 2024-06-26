<?php

use App\Controllers\BookingController;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;
use App\Middleware\AuthJwt;

return function ($app) {
    // Rotas sem JWT
    $app->post("/api/booking/price", BookingController::class . ':getTotalPriceBooking');
    // Rotas protegidas com JWT
    $app->group('/api', function (RouteCollectorProxy $group) {
       $group->post("/booking/create", BookingController::class . ':createNewBooking');
       $group->get("/booking/user/{id}", BookingController::class . ':getBookingByUserId');
       $group->delete("/booking/delete/{id}", BookingController::class . ':deleteBookingById');
    })->add(new AuthJwt());
};