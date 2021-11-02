<?php

use App\Controllers\V1\PasswordRecoveryController;
use App\Controllers\V1\PlaylistController;
use App\Controllers\V1\SecurityController;
use App\Controllers\V1\SubscriptionController;
use App\Controllers\V1\TranslationController;
use Codememory\Routing\Router;

/**
 * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
 * All API routes
 * Example: <protocol>://<host>/api/<path>
 * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
 *
 */

Router::subdomainGroup('api', function () {
    // Registration
    Router::post('/register', SecurityController::class . '#register');
    Router::options('/register', fn () => null);

    // Account activation
    Router::get('/register/activate/:token', SecurityController::class . '#accountActivation')
        ->with('token', '.+');
    Router::options('/register/activate/:token', fn () => null)
        ->with('token', '.+');

    // Authorization
    Router::post('/auth', SecurityController::class . '#auth');
    Router::options('/auth', fn () => null);

    // Routes associated with user passwords
    Router::group('/password-recovery/', function () {
        Router::post('restore-request/', PasswordRecoveryController::class . '#restoreRequest');
        Router::post('change/', PasswordRecoveryController::class . '#change');
    });

    Router::resource('/playlist', PlaylistController::class);
    Router::resource('/subscription', SubscriptionController::class);

    Router::get('/translations', TranslationController::class . '#all');
    Router::options('/translations', fn () => null);
});