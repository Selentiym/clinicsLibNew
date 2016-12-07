<?php

class PricesModule extends CWebModule
{
	/**
	 * @var Rule $rule
	 */
	private $rule;
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'prices.models.*',
			'prices.components.*',
		));

		$this -> rule = Rule::model() -> customFind(null,$_GET, Rule::USE_RULE);
	}

	/**
	 * @param PriceBlock[] $blocks
	 * @return PriceBlock[]
	 */
	public function getPositionedBlocksArray($blocks){
		//Сначала перемещаем блоки
		foreach (array_reverse($this -> rule -> prices) as $price) {
			//Перемещаем блоки с нужными ценами в начало массива
			$block = $price -> block;
			$key = array_search($block, $blocks);
			if ($key) {
				array_splice($blocks, $key, 1);
				array_unshift($blocks, $block);
			}
		}
		$highlight = array_reverse(CHtml::giveAttributeArray($this -> rule -> prices, 'id'));
		//Теперь перемещаем цены внутри блоков
		foreach ($blocks as $block) {
			$prices_initial = $block->prices;
			$prices = array();
			foreach ($prices_initial as $price) {
				/**
				 * @type Price $price
				 */
				if (in_array($price->id, $highlight)) {
					$price -> setHightlight();
					array_unshift($prices, $price);
				} else {
					array_push($prices, $price);
				}
			}
			$block -> setOrderedPrices($prices);
		}
		return $blocks;
		//$light = array_reverse(CHtml::giveAttributeArray($this -> rule -> prices, 'id'));
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
}
