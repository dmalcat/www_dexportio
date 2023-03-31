<?php

declare(strict_types=1);

namespace FreshBangApp\Presenters;

use Nette\Application\Request;
use Nette\Application\BadRequestException;
use Tracy\ILogger;


final class Error4xxPresenter extends BasePresenter
{
	/** @var ILogger @inject */
	public ILogger $logger;

	/**
	 * @throws BadRequestException
	 */
	public function startup(): void
	{
		parent::startup();

		if (! $this->getRequest()->isMethod(Request::FORWARD)) {
			$this->error();
		}
	}


	/**
	 * @param BadRequestException $exception
	 */
	public function renderDefault(BadRequestException $exception): void
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . "/templates/Error/{$exception->getCode()}.latte";
		$this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
	}
}