<?php
class CallTrackerModule extends \CWebModule
{
	/**
	 * @var callable $afterImport
	 */
	public $afterImport;
	public $formatNumber;
	/**
	 * @var CallTrackerModule
	 */
	public static $lastInstance;
	public $defaultController = 'CT';
	const requestDelay = 15000;
	const delayTimesTillGarbage = 2;
	/**
	 * @var aEnterFactory
	 */
	private $_enterFactory;
	/**
	 * @var string $_assetsUrl
	 */
	private $_assetsUrl;
	/**
	 * @var aEnter объект захода
	 */
	public $enter;

	public function getAssetsUrl() {
		if ($this->_assetsUrl === null)
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish($this -> basePath.'/assets/');
		return $this->_assetsUrl;
	}

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
				$this -> getId() . '.models.*',
				$this -> getId() . '.components.*',
		));

		self::$lastInstance = $this;

		//call a client-code function to set some non-trivial configurations
		if (is_callable($this -> afterImport)) {
			call_user_func($this -> afterImport, $this);
		}

		//Если не нужно выдвать номер
		if ($_GET['nonumber'] != 'off') {
			if (($_GET['nonumber']) || (Yii::app()->request->cookies['nonumber']->value)) {
				$this->enter = new Enter();
				$fake = new phNumber();
				$fake->number = 'debugMode!';
				$this->enter->setNumber($fake);
				Yii::app()->request->cookies['id_enter'] = new CHttpCookie('nonumber', 1);
				return;
			}
		} else {
			//Сбрасываем всю информацию
			unset(Yii::app()->request->cookies['id_enter']);
		}
		aEnterFactory::setModule($this);

		//Пытаемся найти заход
		$enter = $this -> lookForEnter();

		$enter = $enter -> collectDataFromRequest();

		$num = $enter -> obtainNumber();

		$this -> enter = $enter;

		//Сохраняем заход
		$this -> enter -> save();

		//Сохраняем ид захода, чтобы потом не забыть
		$this -> setCachedId($this -> enter -> id);

		$this -> loadScripts($this -> enter);
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

	/**
	 * Завершаем текущий заход
	 */
	public function completeEnter(){
		//Этот заход завершен, забываем его id
		$this -> setCachedId(false);
		$this -> enter -> endOneself();
	}

	/**
	 * @return aEnter
	 */
	private function lookForEnter () {
		return aEnterFactory::getFactory() -> build();
	}

	/**
	 * @param aEnter $enter
	 */
	private function loadScripts(aEnter $enter) {
		if (!Yii::app() -> request -> isAjaxRequest) {
			$url = $this -> getAssetsUrl().'/js/tracker.js';
			//echo "<script src='$url'></script>";
			//Передали на страницу идентификатор захода пользователя
			$trace = $this -> enter -> called ? 'false' : 'true';
			Yii::app() -> getClientScript() -> registerScript($this -> getBaseScriptName().'defineConstants','
				window.callTrackerJS = {};
				callTrackerJS.id_enter = '.$this -> enter -> id.';
				callTrackerJS.delay = '.self::requestDelay.';
				callTrackerJS.traceGoal = '.$trace.';
			',CClientScript::POS_BEGIN);
			Yii::app() -> getClientScript() -> registerScriptFile($url, CClientScript::POS_END);
		}
	}

	/**
	 * Возвращает базовое имя скрипта, чтобы не было конфликтов
	 * при назначении скриптов с одинаковыми именами в разных модулях.
	 * @return string
	 */
	private function getBaseScriptName() {
		return md5($this -> getAssetsUrl());
	}

	/**
	 * @return int
	 */
	public function getCachedId(){
		return Yii::app() -> request -> cookies['id_enter'] -> value;
		return false;
	}

	/**
	 * @param integer $val
	 */
	public function setCachedId($val) {
		Yii::app() -> request -> cookies['id_enter'] = new CHttpCookie('id_enter', $val);
	}

	/**
	 * @return iEnterFactory
	 */
	public function getEnterFactory() {

	}

	/**
	 * На случай, если вдруг не найдется модуля для
	 * инициализации фабрики входов
	 * @return string
	 */
	public static function giveLastInstanceId() {
		return 'tracker';
	}
	public function log($str) {
		$f = fopen($this -> logFileName(),'a+');
		fwrite($f, 'date: '.date('r').'<br/>'.PHP_EOL);
		fwrite($f, '<pre>'.$str.'</pre><br/>'.PHP_EOL);
		fwrite($f, '-----------<br/>'.PHP_EOL);
		fclose($f);
	}
	public function logFileName() {
		return __DIR__ . '/'.$this->getId().'.log';
	}

	/**
	 * @param $id
	 * @return CallTrackerModule
	 */
	public static function useTracker($id = 'tracker') {
		return Yii::app() -> getModule($id);
	}
	public static function removeGarbage() {
		$enters = aEnterFactory::getFactory() -> giveUnfinished();
		foreach ($enters as $enter) {
			if (!$enter -> checkTimeValidity()) {
				$enter -> endOneself();
			}
		}
	}

	/**
	 * @return CallTrackerModule
	 */
	public static function getLastInstance() {
		return self::$lastInstance;
	}

	/**
	 * @return string
	 */
	public static function getNumber() {
		return self::$lastInstance -> enter -> getNumber() -> getNumberString();
	}
	/**
	 * @return string
	 */
	public static function getFormattedNumber() {
		$inst = self::$lastInstance;
		$seed = self::getNumber();
		if (is_callable($inst -> formatNumber)) {
			$seed = call_user_func($inst -> formatNumber, $seed);
		}
		return $seed;
	}

	/**
	 * @return string
	 */
	public static function getShortNumber() {
		return self::$lastInstance -> enter -> getNumber() -> getShortNumberString();
	}
	public static function getExperiment() {
		return self::$lastInstance -> enter -> getExperiment();
	}
}