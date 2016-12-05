<h1><?php echo CHtml::encode('Редактировать значение триггера <' . $model->value . '>'); ?></h1>

<?php $this->renderPartial('//triggervalues/_form', array('model'=>$model)); ?>