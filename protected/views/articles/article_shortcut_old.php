<!--<div class="article_shortcut">
	<a class="a_shortcut" href="<?php echo $baseArticleUrl."/".$article['verbiage']; ?>">
		<div>
		<span class="name"><?php echo $article['name'];?></span><span class="count"><?php if ($article['c'] > 0) echo $article['c']; ?></span>
		</div>
	</a>
</div>-->
<li class='main'>
	<a class="a_shortcut" href="<?php echo $baseArticleUrl."/".$article['verbiage']; ?>">
		<?php echo $article['name'];?><!--<span class="count"><?php if ($article['c'] > 0) echo $article['c']; ?></span>-->
	</a>
</li>