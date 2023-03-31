<?php

namespace Dexportio\Components\CookieAgreement;


interface CookieAgreementControlFactory
{
	/**
	 * @return CookieAgreementControl
	 */
	public function create(): CookieAgreementControl;
}
