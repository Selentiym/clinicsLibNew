<?php

class DefaultController extends GDController
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionCheck(){
		var_dump($this -> getModule() -> lookForGD([
			'number' => '+79523660187',
			'to' => time() + 60*60*24*40,
			'from' => time()
		]));

	}
	public function actionObtainStatuses() {
		$this->getModule() -> setImport(array(
			'application.components.googleDocPlusTracker.*',
		));
		$targeted = googleDocEnter::model() -> findAllByAttributes(['called' => 1]);
		//$target = end($targeted);
		$statuses = [];
		//$targeted = array_slice($targeted, -2);
		foreach ($targeted as $target) {
			//$gdCalls = $target -> getGDCalls();
			/**
			 * @type googleDocEnter $target
			 */
			$statuses[$target -> getStatus()] ++;
		}
		var_dump($statuses);
	}
	public function actionDrawGraphic(){
		$this->getModule() -> setImport(array(
				'application.components.googleDocPlusTracker.*',
		));
		$targeted = googleDocEnter::model() -> findAllByAttributes(['called' => 1]);
		$this -> render('googleDoc.views.drawData',['data' => $targeted]);
	}
}