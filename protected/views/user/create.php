<h1><?php echo CHtml::encode('Создать пользователя'); ?></h1>

<?php $this->renderPartial('//user/_form', array('model'=>$model)); ?>