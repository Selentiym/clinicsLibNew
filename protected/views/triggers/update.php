<h1><?php echo CHtml::encode('Редактировать триггера <' . $model->name . '>'); ?></h1>

<?php $this->renderPartial('//triggers/_form', array('model'=>$model)); ?>