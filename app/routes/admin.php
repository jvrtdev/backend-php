<?php

use App\Controllers\UploadController;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\VehicleController;
use App\Controllers\BookingController;
use App\Middleware\AuthAdminJwt;

return function ($app) {
    $app->group('/api/admin', function (RouteCollectorProxy $group) {
      // rotas do usuario
      $group->get('/users', UserController::class . ':getUsers');
      $group->delete('/user/delete/{id}', UserController::class . ':deleteUserById');
      $group->get('/user/{id}', UserController::class . ':getUserById');

      // rotas dos veículos
      $group->post('/upload/vehicle/{id}', UploadController::class . ':uploadVehicleImages');
      $group->post('/vehicle/create', VehicleController::class . ':createVehicle');
      $group->put('/vehicle/update/{id}', VehicleController::class . ':updateVehicleById');
      $group->delete('/vehicle/delete/{id}', VehicleController::class . ':deleteVehicleById');
      $group->get('/vehicle/available', AdminController::class . ':GetVehicleByAvailable');

      // rotas das reservas
      $group->get("/booking/{id}", BookingController::class . ':getBookingById');
      $group->get("/bookings", BookingController::class . ':getAllBookings');
      $group->delete("/booking/delete/{id}", BookingController::class . ':deleteBookingById');

      // rotas dos dados
      $group->get('/data', AdminController::class . ':getAdminData');

      // upload de imagem 
      $group->post('/upload/vehicle/{id}', UploadController::class . ':uploadVehicleImg');

    })->add(new AuthAdminJwt());
    
};