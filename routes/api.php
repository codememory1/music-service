<?php

use App\Controllers\V1\PasswordRecoveryController;
use App\Controllers\V1\PlaylistController;
use App\Controllers\V1\SecurityController;
use App\Controllers\V1\SubscriptionController;
use App\Controllers\V1\TrackController;
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
    Router::post('/register', [SecurityController::class, 'register'], true);

    // Account activation
    Router::get('/register/activate/:token', [SecurityController::class, 'accountActivation'], true)
        ->with('token', '.+');

    // Authorization
    Router::post('/auth', [SecurityController::class, 'auth'], true);

    // Routes associated with user passwords
    Router::group('/password-recovery/', function () {
        Router::post('restore-request/', [PasswordRecoveryController::class, 'restoreRequest'], true);
        Router::post('change/', [PasswordRecoveryController::class, 'change'], true);
    });

    Router::resource('/playlist', PlaylistController::class);
    Router::resource('/subscription', SubscriptionController::class);

    // Routes are associated with languages
    Router::group('/language/', function () {
        Router::get('translations/', [TranslationController::class, 'translations'], true);
        Router::post('create/', [TranslationController::class, 'createLanguage'], true);
        Router::post(':lang/translations/add/', [TranslationController::class, 'addTranslation'], true)->with('lang', '[a-z]+');

        Router::group('cache/', function () {
            Router::put('update/', [TranslationController::class, 'updateCache'], true);
        });
    });

    // Routes associated with music
    Router::group('/track', function () {
        Router::post('/add', [TrackController::class, 'add'], true);
    });
});