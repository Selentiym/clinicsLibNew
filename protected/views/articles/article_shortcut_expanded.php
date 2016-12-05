<li class='article_shortcut'>
	<a class="a_shortcut" href="<?php echo $baseArticleUrl."/".$article['verbiage']; ?>">
		<?php echo $article['name'];?><!--<span class="count"><?php if ($article['c'] > 0) echo $article['c']; ?></span>-->
	</a>
	<div>
		<?php echo CHtml::cutText(strip_tags($article['text']), 20,'..');?>
		<?php //echo CHtml::giveFirstP($article['text']) ; ?>
	</div>
</li>