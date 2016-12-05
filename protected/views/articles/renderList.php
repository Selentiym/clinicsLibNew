<ul>
	<?php
		foreach($articles as $a) {
			$this -> renderPartial('//articles/article_shortcut',array('article' => $a,'baseArticleUrl' => Yii::app() -> baseUrl.'/article'));
		}
	?>
</ul>