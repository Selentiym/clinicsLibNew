<?php
/**
* Yandex map extension for Yii
*
* @author sergmoro1@ya.ru
* @site: lisette.su
* @ license: GPL
*
*/

class yaMap extends CWidget
{
	public $visible=0;
	public $points = array();
	public $params = array('visible'=>0,'zoom'=>13,'width'=>'420px','height'=>'210px');

	public function init()
	{
		// If we have no points, just don't do anything
		if(count($this->points) == 0) {
			$this->visible=0;
			return;
		}

		Yii::app()->clientScript->registerScript(0,
			'yaMapPoints='.CJSON::encode($this->points).';'.
			'yaMapParams='.CJSON::encode($this->params).';',
			CClientScript::POS_READY
		);
		
		$this->publishAssets();

        parent::init();
	}
	
    public function run()
    {
		$this->render('yaMap');
	}

	public function publishAssets()
	{
		$assets = dirname(__FILE__).'/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		if(is_dir($assets)) 
		{
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU');
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/yamap.js', CClientScript::POS_HEAD);
		} else 
		{
			throw new Exception('yaMap - Error: Couldn\'t find assets to publish.');
		}
	}
}
