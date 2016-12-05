<?php

class GoogleDocModule extends CWebModule {

	public $config;
	public $spreadsheet;
	public $worksheet;

	//protected $api;
	public $api;

	public function init() {
		// import the module-level models and components
		$this->setImport(array(
			'googleDoc.models.*',
			'googleDoc.components.*',
			'googleDoc.components.exceptions.*',
			'googleDoc.components.factories.*',
		));

		$this -> api = GoogleDocApiHelper::getInstance($this -> config);
		unset ($this -> config);

		if (!$this -> api -> success) {
			throw new GoogleDocApiException('Api has not been loaded. Check the config!');
		}
		//Ставим нужный гугл документ
		$this -> api -> setWorkArea($this -> spreadsheet);
		//Ставим всем фабрикам по умолчанию api
		aGDCallFactory::setApi($this -> api);
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	public function lookForGD($info) {
		return aGDCallFactory::getFactory($info) -> buildByInfo($info);
	}
}
