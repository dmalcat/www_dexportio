<?php

namespace FreshBangApp\Components\CookieAgreement;


interface CookieAgreementControlFactory
{
	/**
	 * @return CookieAgreementControl
	 */
	public function create(): CookieAgreementControl;
}
