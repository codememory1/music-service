<?php

use Codememory\Components\Environment\Environment;
use Codememory\FileSystem\File;

require_once __DIR__ . '/../vendor/autoload.php';

Environment::__constructStatic(new File());