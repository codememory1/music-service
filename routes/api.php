<?php

use App\Controllers\V1\AuthController;
use App\Controllers\V1\PlaylistController;
use App\Controllers\V1\RegisterController;
use App\Controllers\V1\SubscriptionController;
use Codememory\Routing\Router;

/**
 * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
 * All API routes
 * Example: <protocol>://<host>/api/<path>
 * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
 *
 */

Router::subdomainGroup('api', function () {
    Router::post('/register', RegisterController::class . '#register');
    Router::get('/register/activate/:token', RegisterController::class . '#activation')->with('token', '.+');
    Router::post('/auth', AuthController::class . '#auth');

    Router::resource('/playlist', PlaylistController::class);
    Router::resource('/subscription', SubscriptionController::class);
});