<?php

declare(strict_types=1);

use Nette\Application\Application;

if (file_exists(__DIR__ . '/.maintenance.php')) {
	require __DIR__ . '/.maintenance.php';
}

require __DIR__ . '/../vendor/autoload.php';

Dexportio\Bootstrap::boot()
	->createContainer()
	->getByType(Application::class)
	->run();
