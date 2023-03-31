<?php

namespace FreshBangApp\Components\CookieAgreement;

use Freshio\Localization\Localization;
use Nette\Application\UI\Control;
use Nette\Http;
use Nette\Application\AbortException;


/**
 * @author Roman Pistek (SFN)
 */
final class CookieAgreementControl extends Control
{
	/** @var Localization @inject */
	public Localization $localization;

	private Http\Response $response;
	private bool $hidden;

	/** @const string */
	public const COOKIE_NAME = 'freshbangapp-cookie-agreed';


	/**
	 * @param Http\Request  $request
	 * @param Http\Response $response
	 * @param Localization  $localization
	 */
	public function __construct(Http\Request $request, Http\Response $response, Localization $localization)
	{
		$this->response = $response;

		$this->hidden = $request->getCookie(self::COOKIE_NAME) === 'yes';

		$this->localization = $localization;
	}



	public function render(): void
	{
		if ($this->hidden) {
			return;
		}

		$this->template->setTranslator($this->localization->getTranslator());
		$this->template->setFile(__DIR__ . '/cookieAgreement.latte');
		$this->template->render();
	}


	/**
	 * @throws AbortException
	 */
	public function handleShowCookiesInfo(): void
	{
		$this->getPresenter()->redirect('About:cookiesInfo');
	}


	/**
	 * @throws AbortException
	 */
	public function handleAgree(): void
	{
		$this->response->setCookie(self::COOKIE_NAME, 'yes', '365 days');

		if ($this->getPresenter()->isAjax()) {
			$this->getPresenter()->payload->success = true;
			$this->getPresenter()->sendPayload();
		}

		$this->getPresenter()->redirect('this');
	}
}
