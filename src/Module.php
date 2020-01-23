<?php namespace Zenit\Bundle\SmartPageResponder;

use Zenit\Bundle\SmartPageResponder\Component\Twigger\Twigger;
use Zenit\Core\Event\Component\EventManager;
use Zenit\Core\Module\Interfaces\ModuleInterface;

class Module implements ModuleInterface{
	public function load($moduleConfig){
		EventManager::listen(Twigger::EVENT_TWIG_ENVIRONMENT_CREATED, function () use ($moduleConfig){
			Twigger::Service()->addPath(__DIR__ . '/@resource/', 'smartpage');
			if (is_array($moduleConfig) && array_key_exists('twig-sources', $moduleConfig)) foreach ($moduleConfig['twig-sources'] as $namespace => $source){
				Twigger::Service()->addPath($source, $namespace);
			}
			if(array_key_exists('twig-source', $moduleConfig)){
				Twigger::Service()->addPath($moduleConfig['twig-source'], '__main__');
			}
		});
	}

}