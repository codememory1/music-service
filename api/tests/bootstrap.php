<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Filesystem;

require \dirname(__DIR__) . '/vendor/autoload.php';

(new Filesystem())->remove([__DIR__ . '/../var/cache/test']);

if (file_exists(\dirname(__DIR__) . '/config/bootstrap.php')) {
    require \dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(\dirname(__DIR__) . '/.env');
}
