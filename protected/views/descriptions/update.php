<h1><?php echo CHtml::encode('Редактировать описание к перечню триггеров <'. $model->giveTriggerString() .'>'); ?></h1>

<?php $this->renderPartial('//descriptions/_form', array('model'=>$model)); ?>