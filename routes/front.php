<?php

use Codememory\Routing\Router;
use App\Controllers\FrontendController;

Router::get('/:path', [FrontendController::class, 'home'])->with('path', '.*');

Router::group('/player/', function () {
    Router::get(':path/', [FrontendController::class, 'player'])
        ->with('path', '.*');
});