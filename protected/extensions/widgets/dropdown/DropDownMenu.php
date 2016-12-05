<?php
/**
 * DropDownMenu class file.
 * @author Bondartsev Nikita <bondartsev.nikita@gmail.com>
 */


/**
 * Hover-dropdown navigation bar widget.
 */
class DropDownMenu extends CWidget
{
	private $levelNames = array('First', 'Second', 'Third');
	/**
	 * @var array the HTML attributes for the parent ul
	 */
	public $htmlOptions = array();
	/**
	 * @var array navigation items.
	 */
	public $items = array();
	/**
	 * @var boolean whether to register default css
	 */
	public $registerCss = true;
	/**
	 * in all view files for this widget these variables ar available:
	 * @var string text - the text to be displayed
	 * @var string url - url of the menu item
	 */
	/**
	 * @var string first level view
	 */
	public $viewFirstLevel = '';
	/**
	 * @var string second level view
	 */
	public $viewSecondLevel = '';
	/**
	 * @var string third level view
	 */
	public $viewThirdLevel = '';
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		//publish resources.
		$assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($assets . '/js/jquery.dropdownPlain.js');
		if ($this -> registerCss){
			$cs->registerCssFile($assets . '/css/style.css');
		} else {
			$cs->registerCssFile($assets . '/css/funcCss.css');
		}
		//Add the dropdownclass for the js to be added to this menu
		if (!strpos($this -> htmlOptions['class'], 'dropdown'))
		{
			$this -> htmlOptions['class'] .= ' dropdown';
		}
		
		$this -> viewFirstLevel = $this -> viewFirstLevel ? $this -> viewFirstLevel : 'ext.widgets.dropdown.views._first';
		$this -> viewSecondLevel = $this -> viewSecondLevel ? $this -> viewSecondLevel : 'ext.widgets.dropdown.views._first';
		$this -> viewThirdLevel = $this -> viewThirdLevel ? $this -> viewThirdLevel : 'ext.widgets.dropdown.views._first';
		
		//$this->controller->render('ext.elFinder.views.ServerFileInputElFinderPopupAction', array('title' => $this->title,
		return;
	}
	public function renderItem($item, $level){
		if (is_array($item['items'])&&(!empty($item['items']))) {
			$text = CHtml::openTag('ul');
			foreach($item['items'] as $subitem){
				$text .= $this -> renderItem($subitem, $level+1);
			}
			$text .= CHtml::closeTag('ul');
		}
		$viewName = 'view'.$this -> levelNames[$level].'Level';
		return $this -> controller -> renderPartial ($this -> $viewName, array(
			'text' => $item['label'],
			'url' => $item['url'],
			'descendants' => $text
		),true, false);
	}
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::openTag('ul', $this->htmlOptions);
		
		foreach ($this->items as $item)
		{
			echo $this -> renderItem($item, 0);
		}

		echo CHtml::closeTag('ul');
	}
}
