<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\RobotCommand;

$app = new Application('Cleaner Robot', 'v1.0.0');
$app -> add(new RobotCommand());
$app->run();
