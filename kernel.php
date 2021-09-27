<?php

use Kernel\Kernel;

require_once 'vendor/autoload.php';

/**
 * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
 * Creation and assembly of the framework core
 * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
 */
(new Kernel())->build()->run();
