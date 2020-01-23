<?php namespace Zenit\Bundle\SmartPageResponder\Component\Responder;


use Zenit\Bundle\SmartPageResponder\Config;
abstract class SmartPageResponder extends TwigPageResponder{

	protected $title;
	protected $bodyclass;
	protected $language;
	protected $js;
	protected $css;

	protected function getViewModelData(){return $this->selfViewModel ?  call_user_func('get_object_vars', $this) : $this->getDataBag()->all(); }

	protected function createViewModel(){
		return [
			'data'      => $this->getViewModelData(),
			'smartpage' => $this->getViewModelSmartPageComponents(),
		];
	}

	private function getViewModelSmartPageComponents(){

		$config = Config::Service();

		return [
			'clientversion' => $config->clientVersion,
			'title'         => $this->title ? $this->title : $this->annotations->get('title'),
			'language'      => $this->language ? $this->language : $this->annotations->get('language', $config->language),
			'bodyclass'     => $this->bodyclass ? $this->bodyclass : $this->annotations->get('bodyclass'),
			'css'           => $this->css ? $this->css : $this->annotations->getAsArray('css'),
			'js'            => $this->js ? $this->js : $this->annotations->getAsArray('js'),
			'favicon'       => $this->annotations->get('favicon') ? $this->annotations->get('favicon') : '/~favicon/',
		];
	}

}





