<?php
	class FileViewAction extends CAction
	{
		
		/**
		 * @var callable access function to be called to access page
		 */
		public $access;
		/**
		 * @var string view for render
		 */
		public $view;
		/**
		 * @var boolean - allow everyone including guests visit this page
		 */
		public $everyone = false;
		
		/**
		 * @param $arg string model argument to be taken into customFind
		 * @throws CHttpException
		 */
		public function run()
		{
			if ((!Yii::app() -> user -> isGuest)||($this -> everyone)) {
				if (is_callable($this -> access)) {
					$name = $this -> access;
					if ($name()) {
						$this->controller->render($this->view, array('get' => $_GET));
					} else {
						$this -> controller -> render('//accessDenied');
					}
				}
				//}
			} else {
				$this -> controller -> redirect(Yii::app() -> baseUrl.'/');
			}
		}
	}
?>