<?php

use Codememory\Routing\Router;
use App\Controllers\FrontendController;

Router::get('/:path', [FrontendController::class, 'home'])->with('path', '.*');

Router::subdomainGroup('player', function () {
    Router::get('/:path', [FrontendController::class, 'player'])->with('path', '.*');
});

Router::subdomainGroup('account', function () {
    Router::get('/:path', [FrontendController::class, 'account'])->with('path', '.*');
});