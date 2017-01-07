<div id="mrt" class="collapse mine_tab_opened" style="display: block;">
	<div class="tab_container">
	<!--МРТ головы и шеи-->
	<table>
		<?php
		$module = Yii::app() -> getModule('prices');
		$mrtPrices = $module -> getPositionedBlocksArray(PriceBlock::model() -> findAllByAttributes(['category_name' => 'mrt']));
			foreach($mrtPrices as $block) {
				$this -> renderPartial('//landingLike/_price_block',['block' => $block]);
			}
		?>	
	</table></div>
	<div class="clear"></div>
</div>
<div id="kt" class="collapse">
	<div class="tab_container">
		 <!--КТ головы и шеи-->
		 <table>
			<?php
				$ktPrices = $module -> getPositionedBlocksArray(PriceBlock::model() -> findAllByAttributes(['category_name' => 'kt_']));
				foreach($ktPrices as $block) {
					$this -> renderPartial('//landingLike/_price_block',['block' => $block]);
				}
			$selPrices = $module -> getPositionedBlocksArray(PriceBlock::model() -> findAllByAttributes(['category_name' => 'sel']));
				foreach($selPrices as $block) {
					$this -> renderPartial('//landingLike/_price_block',['block' => $block]);
				}
				?>
		</table>
		<div class="clear"></div>
	</div>
</div>
<!---->
