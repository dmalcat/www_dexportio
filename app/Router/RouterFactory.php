<?php

declare(strict_types=1);

namespace FreshBangApp\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Http\Request;


final class RouterFactory
{
	use Nette\StaticClass;

	/** @var string */
	public const    LOCAL_DEV = 'local_dev',
		DEV_STAGE = 'dev_stage',
		LIVE      = 'live';

	/** @var string[]  */
	public const    REGIONS = [ 'cz', 'sk' ];


	/**
	 * @param Request $request
	 * @param string  $basePath
	 * @return RouteList
	 */
	public static function createRouter(Request $request, $basePath = ''): RouteList
	{
		$router = new RouteList;

		if (self::estimateEnvironment($request) !== self::LIVE) {

			$router->addRoute('', [
				'presenter' 	=> 'Homepage',
				'action' 		=> 'default',
				'region' 		=> self::REGIONS[0]
			], Nette\Routing\Route::ONE_WAY);


			foreach (self::REGIONS as $region) {

				$router->addRoute($basePath . $region . '/', [
					'presenter' 	=> 'Homepage',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/styleguide', [
					'presenter' 	=> 'Styleguide',
					'action' 		=> 'default',
					'region' 		=> $region
				]);
			}

		} else {

			$router->addRoute('//www.domain-name.cz', [
				'presenter' => 'Homepage',
				'action'    => 'default',
				'region'    => 'cz'
			], Nette\Routing\Route::ONE_WAY);

			$router->addRoute('//www.domain-name.sk', [
				'presenter' => 'Homepage',
				'action'    => 'default',
				'region'    => 'sk'
			], Nette\Routing\Route::ONE_WAY);

			$router->addRoute('//www.domain-name.cz/', [
				'presenter' 	=> 'Homepage',
				'action' 		=> 'default',
				'region' 		=> 'cz'
			]);

			$router->addRoute('//www.domain-name.sk/', [
				'presenter' 	=> 'Homepage',
				'action' 		=> 'default',
				'region' 		=> 'sk'
			]);
		}

		return $router;
	}


	/**
	 * @param Request $request
	 * @return string
	 */
	private static function estimateEnvironment(Request $request): string
	{
		static $hostPatterns = [
			'localhost'                    => self::LOCAL_DEV,
			'domain-name\.freshdev80\.cz'  => self::DEV_STAGE,
			'www\.domain-name\.cz'         => self::LIVE,
			'www\.domain-name\.sk'         => self::LIVE
		];

		$host = $request->getUrl()->getHost();

		foreach ($hostPatterns as $pattern => $env) {
			if (Nette\Utils\Strings::match($host, "~^$pattern$~")) {
				return $env;
			}
		}

		return self::LOCAL_DEV;
	}
}
