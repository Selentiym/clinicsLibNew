<div class="object_image_cont">
	<img onClick="location.href='<?php echo Yii::app() -> baseUrl.'/doctors/'.$data->verbiage; ?>'" src="<?php echo $data -> giveImageFolderRelativeUrl() . $data -> logo;?>" alt="<?php echo $data->name; ?>"/>
</div>
<div class="doc_fio">
	<?php echo CHtml::link($data -> name, Yii::app() -> baseUrl.'/doctors/'.$data->verbiage); ?>
</div>