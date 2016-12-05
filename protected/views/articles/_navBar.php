<div class="hleb">
	<ul>
	
	<?php 
		$verbiage = Yii::app() -> baseUrl."/article";
		echo '<li class="hleb_first">'.CHtml::link('Библиотека', $verbiage, array('rel' => 'nofollow')).'</li>';
		
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
				
				
				echo '<li>'.CHtml::link($parent['name'], $verbiage, array('rel' => 'nofollow')).'</li>';
				//echo '<div class="arrow"></div>';
			}
			echo '<li>'.CHtml::link($article['name'], $verbiage.'/'.$article['verbiage'], array('rel' => 'nofollow')).'</li>';
		}
	?>
	</ul>
</div>