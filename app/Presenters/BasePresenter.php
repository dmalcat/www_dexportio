<?php

declare(strict_types=1);

namespace FreshBangApp\Presenters;

use Freshio\Localization\Localization;
use Freshio\Mailing\Mailing;
use Freshio\Presets\Presets;
use Freshio\Utils\AssetVersioning;
use Nette;
use Nette\Application\UI\Template;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var AssetVersioning @inject */
	public AssetVersioning $assetVersioning;

	/** @var Localization @inject */
	public Localization $localization;

	/** @var Presets @inject */
	public Presets $presets;

	/** @var Mailing @inject */
	public Mailing $mailing;

	/** @var string @persistent */
	public $region;


	public function startup(): void
	{
		parent::startup();

		// localization
		$loc = $this->localization;
		$loc->setRegion($this->getParameter('region', 'cz'));
		$loc->setLanguage($loc->getRegion() === 'sk' ? 'sk' : 'cs');
	}


	/**
	 * @return Template
	 */
	protected function createTemplate(): Template
	{
		$tpl = parent::createTemplate();

		$tpl->setTranslator($this->localization->getTranslator());

		$tpl->addFilter('asset', function($assetPath) use ($tpl) {
			return $this->assetVersioning->appendVersionSuffix($assetPath, $tpl->basePath);
		});

		$tpl->addFilter('phone', function ($phone) {
			return $this->formatPhone($phone);
		});

		$tpl->presets = $this->presets;
		$tpl->language = $this->localization->getLanguage();
		$tpl->region = $this->localization->getRegion();

		$tpl->contactMail = $this->presets->getValueIfExists('contact.mail') ?: null;
		$tpl->contactPhone = $this->presets->getValueIfExists('contact.phone') ?: null;

		$tpl->googleAnalyticsCodeCZ = $this->presets->getValueIfExists('analytics.googleAnalytics.cz') ?: null;
		$tpl->googleAnalyticsCodeSK = $this->presets->getValueIfExists('analytics.googleAnalytics.sk') ?: null;

		return $tpl;
	}


	/**
	 * @param string $phone
	 * @return string
	 */
	protected function formatPhone(string $phone): string
	{
		$s1 = substr($phone, 0, 4);
		$s2 = substr($phone, 4, 3);
		$s3 = substr($phone, 7, 3);
		$s4 = substr($phone, 10, 3);

		return '<span class="gray">' . $s1 . '</span> ' . $s2 . ' ' . $s3 . ' ' . $s4;
	}


	/**
	 * @param string $str
	 * @return string
	 */
	public function _(string $str): string
	{
		if (! $translator = $this->localization->getTranslator()) {
			return $str;
		}
		return $translator->translate($str);
	}
}
