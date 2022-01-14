<?php

use App\Controllers\V1\AlbumController;
use App\Controllers\V1\PasswordRecoveryController;
use App\Controllers\V1\PlaylistController;
use App\Controllers\V1\SecurityController;
use App\Controllers\V1\SubscriptionController;
use App\Controllers\V1\TrackController;
use App\Controllers\V1\TranslationController;
use App\Controllers\V1\UserController;
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

    Router::get('/refresh-access-token', [SecurityController::class, 'refreshAccessToken'], true);

    Router::group('/user/', function () {
        Router::get('current/', [UserController::class, 'showCurrentUser'], true);
    });

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
        Router::post(':lang/translations/add/', [TranslationController::class, 'addTranslation'], true)
            ->with('lang', '[a-z]+');

        Router::group('cache/', function () {
            Router::put('update/', [TranslationController::class, 'updateCache'], true);
        });
    });

    // Album routes
    Router::group('/album/', function () {
        Router::post('create/', [AlbumController::class, 'create'], true);
        Router::delete(':id/delete/', [AlbumController::class, 'delete'], true)
            ->with('id', '[0-9]+');
    });

    // Routes associated with music
    Router::group('/track/', function () {
        Router::post('add/', [TrackController::class, 'addTrack'], true);
        Router::put(':hash/edit/', [TrackController::class, 'editTrack'], true)
            ->with('hash', '.+');
        Router::get(':hash/info/', [TrackController::class, 'infoTrack'], true)
            ->with('hash', '.+');
        Router::delete(':hash/delete/', [TrackController::class, 'deleteTrack'], true)
            ->with('hash', '.+');

        Router::group(':hash/text/', function () {
            Router::put('edit/', [TrackController::class, 'editTrackText'], true)
                ->with('hash', '.+');
        });

        Router::group(':hash/subtitles/', function () {
            Router::post('add/', [TrackController::class, 'addSubtitles'], true)
                ->with('hash', '.+');
            Router::post('edit/', [TrackController::class, 'editSubtitles'], true)
                ->with('hash', '.+');
            Router::delete('delete/', [TrackController::class, 'deleteSubtitles'], true)
                ->with('hash', '.+');
        });
    });
});