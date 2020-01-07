<?php namespace Zenit\Bundle\SmartPageResponder\Component;

use Zenit\Bundle\SmartPageResponder\Component\Twigger\Twigger;
use Zenit\Core\Event\Component\EventManager;
use Zenit\Core\Module\Interfaces\ModuleInterface;

class SmartPageResponder implements ModuleInterface{
	public function load($env){
		EventManager::listen(Twigger::EVENT_TWIG_ENVIRONMENT_CREATED, function () use ($env){
			Twigger::Service()->addPath(__DIR__ . '/~twig/', 'smartpage');
			if (is_array($env) && array_key_exists('twig-sources', $env)) foreach ($env['twig-sources'] as $namespace => $source){
				Twigger::Service()->addPath($source, $namespace);
			}
		});
	}

}