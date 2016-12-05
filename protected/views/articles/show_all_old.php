<?php $cs = Yii::app()->getClientScript(); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/article_list.css'); ?>
<?php
	$count = count($articles);
	$c = 0;
	$first_column = array();
	$second_column = array();
	foreach($articles as $a){
		if ($c < $count/2) {
			$first_column[] = $a;
		} else {
			$second_column[] = $a;
		}
		$c++;
	}
?>
<div id="root_articles">
	<h1 id="illness_list">Справочник заболеваний</h1>
	<div id="article_content">
		<!--<div id="search_articles">
			<form name="articles">
				<div class="input_styled">
					<div class="image"><span></span></div>
					<input type="text" name="articles_search" id="art_search"/>
				</div>
				<input type="submit" class="search_submit" value="Найти"/>
			</form>
		</div>-->
		<div id="articles">
			<div id="column1" class="article_column">
				<?php $this -> renderPartial('//articles/renderList', array('articles' => $first_column)); ?>
			</div>
			
			<div id="column2" class="article_column">
				<?php $this -> renderPartial('//articles/renderList', array('articles' => $second_column)); ?>
			</div>
		</div>
	</div>
	
	
	
	<?php // echo $this -> renderPartial('//articles/_navBar', array('article' => false)); ?>
	<table>
		<?php 
			/*function GiveFirstLetter($article){
				$name = (string)$article['name'];
				return mb_substr($name,0,1,'utf-8');
			}
			$count=count($articles);
			echo CHtml::openTag('ul', array('class' => 'letter_block'));
			$firstLetter = GiveFirstLetter(current($articles));
			foreach($articles as $article) {
				if ($firstLetter != GiveFirstLetter($article))
				{
					echo CHtml::closeTag('ul');
					echo CHtml::openTag('ul', array('class' => 'letter_block'));
					$firstLetter = GiveFirstLetter($article);
				}
				echo $this->renderPartial('//articles/article_shortcut', array('article'=>$article, 'baseArticleUrl' => Yii::app() -> baseUrl.'/article'));
			}*/
			
			/*for ($i = 0; $i < $count/3; $i++)
			{
				echo "<tr>";
				for($j = 0; $j < 3; $j++)
				{
					if ($i*3 + $j < $count)
					{
						echo "<td>";
					} else {
						echo "<td class='empty'>";
					}
					echo $this->renderPartial('//articles/article_shortcut', array('article'=>$articles[$i * 3 + $j], 'baseArticleUrl' => Yii::app() -> baseUrl.'/article'));
					echo "</td>";
				}
				echo "</tr>";
				
			}*/
		?>
	</table>
</div>