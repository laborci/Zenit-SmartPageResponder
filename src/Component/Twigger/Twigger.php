<?php namespace Zenit\Bundle\SmartPageResponder\Component\Twigger;

use Zenit\Bundle\SmartPageResponder\Component\SmartPageResponder;
use Zenit\Core\Event\Component\EventManager;
use Zenit\Core\Module\Component\ModuleLoader;
use Zenit\Core\ServiceManager\Component\Service;
use Zenit\Core\ServiceManager\Interfaces\SharedService;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Twigger implements SharedService{

	const EVENT_TWIG_ENVIRONMENT_CREATED = 'EVENT_TWIG_ENVIRONMENT_CREATED';

	use Service;

	/** @var \Twig\Environment */
	protected $twigEnvironment;

	public function render($template, $viewModel){ return $this->getTwigEnvironment()->render($template, $viewModel); }

	protected function getTwigEnvironment(): Environment{

		ModuleLoader::Service()->get(SmartPageResponder::class);

		if (is_null($this->twigEnvironment)){
			$loader = new FilesystemLoader();

			if (array_key_exists('sources', env('twig')))
				foreach (env("twig.sources") as $namespace => $path)
					if (is_dir($path))
						$loader->addPath($path, $namespace);

			$twigEnvironment = new Environment($loader, ['cache' => env("twig.cache"), 'debug' => env("twig.debug")]);
			if (env("twig.debug")) $twigEnvironment->addExtension(new DebugExtension());
			$this->twigEnvironment = $twigEnvironment;
			EventManager::fire(self::EVENT_TWIG_ENVIRONMENT_CREATED, $twigEnvironment);
		}
		return $this->twigEnvironment;
	}

	public function addPath($path, $namespace){
		/** @var \Twig\Loader\FilesystemLoader $loader */
		$loader = $this->getTwigEnvironment()->getLoader();
		$loader->addPath($path, $namespace);
	}

}

