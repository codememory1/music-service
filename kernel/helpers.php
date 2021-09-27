<?php

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @throws ErrorException
 */
function dump($data): void
{

    $cloneVar  = new VarCloner();
    $htmlDumper = new HtmlDumper();

    $htmlDumper->dump($cloneVar->cloneVar($data), function ($line, $depth) use (&$output) {
        if ($depth >= 0) {
            $output .= str_repeat('  ', $depth) . $line . "\n";
        }
    });

    $_SERVER['VAR_DUMPER'][] = $output;

}

/**
 * @param $data
 */
#[NoReturn]
function dd($data): void
{

    VarDumper::dump($data);

    exit(1);

}