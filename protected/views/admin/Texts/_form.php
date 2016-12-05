<?php
/* @var $this RightTextController */
/* @var $model RightText */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'right-text-_form-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>

	<p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,'image'); ?>
		<?php
			if (!empty($model->image)) {
				//$image = Yii::app()->baseUrl.'/images/clinics/' . $model->id . '/' .$model->image;
				$image = $model -> giveImageFolderRelativeUrl() . $model->image;
				echo '<div id="image">' . CHtml::ajaxLink('<i class="icon-remove"></i>', CController::createUrl('admin/propDelete/' . $model->id), array('type'=> 'POST', 'data'=>array('model' => 'RightText', 'prop' => 'image'), 'success' => 'js: $("#image").hide()'))
				 . CHtml::image($image, CHtml::encode('Картинка'),
					array('style' => 'max-width:172px;max-height:200px; padding: 8px 0px 8px 15px;')) . '</div>';
			}
		?>
		<?php echo $form->fileField($model, 'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
	<div>
	<?php echo $form->labelEx($model,'text'); ?>
	<div class='tinymce'>
	<?php
		$this->widget('application.extensions.tinymce.TinyMce',
			array(
				'model'=>$model,
				'attribute'=>'text',
				//'editorTemplate'=>'full',
				'skin'=>'cirkuit',
				
				//'useCompression'=>false,
				'settings'=> array(
					'mode' =>"textareas",
					'theme' => 'advanced',
					'skin' => 'cirkuit',
					'theme_advanced_toolbar_location'=>'top',
					'plugins' => 'advimage,spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,table,template,paste',
					'paste_remove_styles' => true,
					'paste_remove_spans' => true,
					'cleanup' => true,
					'valid_elements' => 'p,ul,li,table,tr,td,tbody,img[src]',
					'paste_word_valid_elements' => "p,ul,li,table,tr,td,tbody",
					'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,removeformat,|,tablecontrols",
					'theme_advanced_buttons2' => "cut,copy,paste,pastetext,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
					//'theme_advanced_buttons2' => "paste,pastetext",
					'theme_advanced_buttons4' => "",
					'theme_advanced_buttons3' => "",
					//'theme_advanced_buttons3' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
					'theme_advanced_toolbar_location' => 'top',
					'theme_advanced_toolbar_align' => 'left',
					'theme_advanced_statusbar_location' => 'bottom',
					'theme_advanced_resizing_min_height' => 30,
					'height' => 300,
					
				),
				
				'fileManager' => array(
							'class' => 'application.extensions.elFinder.TinyMceElFinder',
							'popupConnectorRoute' => 'elfinder/elfinderTinyMce', // relative route for TinyMCE popup action
							'popupTitle' => "Files",
					 ), 
				'htmlOptions'=>array('rows'=>5, 'cols'=>30, 'class'=>'tinymce'),
			));
	?>
	</div>
	<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url'); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>
	
	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->