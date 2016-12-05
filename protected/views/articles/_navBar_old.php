<div id="links">
	<?php 
		$verbiage = Yii::app() -> baseUrl."/article";
		echo CHtml::link('Библиотека', $verbiage);
		if ($article)
		{
			//echo CHtml::encode("->");
			$parents = $article -> GiveParentList($article);
			//foreach($parents as $parent)
			//print_r($parents);
			for ($i = 0; $i < count($parents) - 1; $i ++)
			{
				$parent = $parents[$i];
				$verbiage .= '/'.$parent['verbiage'];
				echo CHtml::link($parent['name'], $verbiage);
				//echo '<div class="arrow"></div>';
			}
			echo CHtml::link($article['name'], $verbiage.'/'.$article['verbiage']);
		}
	?>
</div>