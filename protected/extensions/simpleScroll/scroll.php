<?php
/**
 * renders a simple scroller widget. Downloads all the images instantly. Not very good.
 */
class scroll extends CInputWidget
{
	/**
	 * @var array images - an array of images to be slided
	 */
	public $images = array();
	
	/**
	 * @var string assets - path to the assets directory
	 */
	private $assets;
	/**
	 * @var string baseAddr - address to be added to all images
	 */
	public $baseAddr = '';
	
	
	public function init()
	{
		$dir = dirname(__FILE__) . '/assets';
		$this -> assets = Yii::app()->assetManager->publish($dir);
		$this -> registerFiles();
	}

	public function run()
	{
		if (!empty($this -> images)) {
			echo '<div id="slider" class="slider_wrap">';
			foreach($this -> images as $image) {
				if (!$image["alt"]) {
					$alt = $image["addr"];
				} else {
					$alt = $image["alt"];
				}
				if (!$image["htmlOptions"]) {
					$image["htmlOptions"] = array();
				}
				if ($image["selected"]) {
					$image["htmlOptions"]["class"] .= ' active';
				}
				echo CHtml::image($this -> baseAddr.$image["addr"], $alt,$image["htmlOptions"]);
			}
			echo '</div>';
		}
	}

	private function registerFiles()
	{
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		
		$cs -> registerScriptFile($this -> assets."/js/scroller.js");
		$cs -> registerCssFile($this -> assets."/css/scroller.css");
	}
}
