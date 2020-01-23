<?php

namespace Zenit\Bundle\SmartPageResponder;

use Zenit\Core\Env\Component\ConfigReader;
class Config extends ConfigReader{

	public $language = "bundle.smartpageresponder.language";
	public $twigCache = "bundle.smartpageresponder.twig.cache";
	public $twigDebug = "bundle.smartpageresponder.twig.debug";
	public $clientVersionFile = "bundle.smartpageresponder.client-version";
	public $clientVersion = "";

	public function __construct(){
		parent::__construct();
		$this->clientVersion = file_exists($this->clientVersionFile) ? file_get_contents($this->clientVersionFile) : 0;
	}
}