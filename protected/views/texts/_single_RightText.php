<?php
	/**
	 * @var object $model - RightText model.
	 */
	$url = str_replace('baseUrl', Yii::app() -> baseUrl, $model -> url);
?>
<div class = 'RightText'>
	<div class = 'image'><a href = "<?php echo $url; ?>"><img src="<?php echo $model -> giveAbsoluteImageFolderUrl() . $model -> image; ?>" alt="Картинка для блока текста"/></a></div>
	<div class = 'text'><a href = "<?php echo $url; ?>"><?php echo $model -> text;?></a></div>
</div>