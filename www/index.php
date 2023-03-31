<?php

declare(strict_types=1);

if (file_exists(__DIR__ . '/.maintenance.php')) {
	require __DIR__ . '/.maintenance.php';
}

require __DIR__ . '/../vendor/autoload.php';

FreshBangApp\Bootstrap::boot()
	->createContainer()
	->getByType(Nette\Application\Application::class)
	->run();
