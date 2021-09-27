<?php

use App\Controllers\Api\V1\RegisterController;
use Codememory\Routing\Router;

/**
 * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
 * All API routes
 * Example: <protocol>://<host>/api/<path>
 * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
 *
 */

Router::group('api/', function () {
    Router::post('register/', RegisterController::class . '#register')->name('register');
});