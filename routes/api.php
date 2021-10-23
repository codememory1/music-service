<?php

use App\Controllers\V1\PlaylistController;
use App\Controllers\V1\SecurityController;
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
    Router::post('/register', SecurityController::class . '#register');
    Router::get('/register/activate/:token', SecurityController::class . '#accountActivation')->with('token', '.+');
    Router::post('/auth', SecurityController::class . '#auth');

    // Routes associated with user passwords
    Router::group('/password/', function () {
        Router::post('restore-request/', SecurityController::class . '#restoreRequest');
        Router::post('recovery/', SecurityController::class . '#recovery');
    });

    Router::resource('/playlist', PlaylistController::class);
    Router::resource('/subscription', SubscriptionController::class);
});