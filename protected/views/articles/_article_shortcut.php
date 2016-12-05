<?php
	$translate = array(
		'Arterii_i_veny' => 'zabolev1.png',
		'LOR' => 'lor.png',
		'Golovnoj_mozg-osnovn' => 'mozg.png',
		'Golova_i_sheja-osnov' => 'heart.png',
		'Grudnaja_kletka-osno' => 'grud.png',
		'Pediatrija' => 'child.png',
		'Kardiologija' => 'kardio.png',
		'Molochnye_zhelezy' => 'moloch.png',
		'Mochepolovaja_sistem' => 'mochep.png',
		'gall' => 'trakt.png',
		'Ortopedija' => 'ortopedia.png'
	);
?>
<div class="zobolevan">
	<img src="<?php echo Yii::app() -> baseUrl; ?>/img/<?php echo $image ?>" alt="arterii">
	<h2><a href="<?php echo $baseArticleUrl."/".$article['verbiage']; ?>"><?php echo $article['name']; ?></a></h2>
	<p>
		<?php echo CHtml::cutText(strip_tags($article['text']), 20,'..');?>
	</p>
</div>