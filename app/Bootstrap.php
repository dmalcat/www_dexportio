<?php

declare(strict_types=1);

namespace FreshBangApp;

use Nette\Configurator;


class Bootstrap
{
	public static function boot(): Configurator
	{
		$configurator = new Configurator;

		//$configurator->setDebugMode(false);
		//$configurator->setDebugMode('77.104.210.51');

		$configurator->enableDebugger(__DIR__ . '/../log', 'webari@freshnet.cz');

		$configurator->enableTracy(__DIR__ . '/../log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig(__DIR__ . '/config/common.neon');
		if (file_exists(__DIR__ . '/config/local.neon')) {
			$configurator->addConfig(__DIR__ . '/config/local.neon');
		}

		return $configurator;
	}
}
