<h1><?php echo CHtml::encode('Редактировать поле <' . $model->title . '>'); ?></h1>

<?php $this->renderPartial('//fields/_form', array('model'=>$model)); ?>