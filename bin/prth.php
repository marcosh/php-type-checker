<?php

declare(strict_types = 1);

use Marcosh\PhpReturnTypeChecker\Command\CheckReturnTypes;
use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';

$application = new Application();

$application->add(new CheckReturnTypes());

$application->run();
