#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use App\Command\Puzzle201901Command;
use App\Command\Puzzle202001Command;

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new Puzzle201901Command());
$application->add(new Puzzle202001Command());

$application->run();