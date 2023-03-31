<?php

declare(strict_types=1);

namespace FreshBangApp\Presenters;

use Nette;
use Nette\Application\BadRequestException;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses;
use Tracy\ILogger;


final class ErrorPresenter extends BasePresenter
{
	use Nette\SmartObject;

	/** @var ILogger @inject */
	public ILogger $logger;


	/**
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request): Response
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof BadRequestException) {

			[$module, , $sep] = Nette\Application\Helpers::splitName($request->getPresenterName());

			return new Responses\ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);

		return new Responses\CallbackResponse(static function () {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}
}
