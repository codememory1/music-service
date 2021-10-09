<?php

use App\Controllers\Api\V1\AuthController;
use App\Controllers\Api\V1\PlaylistController;
use App\Controllers\Api\V1\RegisterController;
use App\Controllers\Api\V1\SubscriptionController;
use Codememory\Routing\Router;

/**
 * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
 * All API routes
 * Example: <protocol>://<host>/api/<path>
 * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
 *
 */

Router::subdomainGroup('api', function () {
    Router::post('register/', RegisterController::class . '#register')->name('register');
    Router::get('register/activate/:token/', RegisterController::class . '#activation')
        ->with('token', '.+')
        ->name('account-activation');
    Router::post('auth/', AuthController::class . '#auth')->name('auth');

    // Playlist routes
    Router::group('playlist/', function () {
        Router::post('create/', PlaylistController::class . '#create')->name('create-playlist');
        Router::get('all/', PlaylistController::class . '#all')->name('all-playlists');
        Router::get('show/:id', PlaylistController::class . '#show')
            ->with('id', '[0-9]+')
            ->name('show-playlist');
        Router::put('update/:id', PlaylistController::class . '#update')
            ->with('id', '[0-9]+')
            ->name('update-playlist');
        Router::delete('delete/:id', PlaylistController::class . '#delete')
            ->with('id', '[0-9]+')
            ->name('delete-playlist');
    });

    // Subscription routes
    Router::group('subscription/', function () {
        Router::get('all/', SubscriptionController::class . '#all')->name('all-subscriptions');
    });
});