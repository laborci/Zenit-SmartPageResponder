<?php namespace Zenit\Bundle\SmartPageResponder\Component\Responder;

use Minime\Annotations\Reader;
use Zenit\Core\ServiceManager\Component\ServiceContainer;
use Zenit\Bundle\SmartPageResponder\Component\Twigger\Twigger;
use Zenit\Bundle\Mission\Module\Web\Responder\PageResponder;
use Minime\Annotations\Interfaces\AnnotationsBagInterface;

abstract class TwigPageResponder extends PageResponder{

	/** @var AnnotationsBagInterface */
	protected $annotations;
	protected $template;

	public function __construct(){
		/** @var Reader $annotationReader */
		$annotationReader = ServiceContainer::get(Reader::class);
		$this->annotations = $annotationReader->getClassAnnotations(get_called_class());
		$this->template = $this->annotations->get('template');
	}
	protected function respond(): string{ return Twigger::Service()->render($this->template, $this->createViewModel()); }
	protected function createViewModel(){ return $this->getDataBag()->all(); }
	protected function setViewModel($name, $value = null){
		if(is_array($name))foreach($name as $key=>$value){
			$this->getDataBag()->set($key, $value);
		}else $this->getDataBag()->set($name, $value);
	}

}