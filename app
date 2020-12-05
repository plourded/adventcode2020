#!/usr/bin/env php
<?php
// application.php

function base_path(string $filename = "")
{
    return __DIR__ . "/" . $filename;
}
function storage_path(string $filename = "")
{
    return __DIR__ . "/storage/" . $filename;
}

require __DIR__.'/vendor/autoload.php';


use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new App\Command\Puzzle201901Command());
$application->add(new App\Command\Puzzle202001Command());
$application->add(new App\Command\Puzzle202002Command());
$application->add(new App\Command\Puzzle202003Command());
$application->add(new App\Command\Puzzle202004Command());

$application->run();