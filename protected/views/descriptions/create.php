<h1><?php echo CHtml::encode('Создать новое описание'); ?></h1>

<?php $this->renderPartial('//descriptions/_form', array('model'=>$model)); ?>