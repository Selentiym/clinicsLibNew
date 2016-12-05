<h1><?php echo CHtml::encode('Создать новое значение триггера'); ?></h1>

<?php $this->renderPartial('//triggervalues/_form', array('model'=>$model, 'trigger_id' => $trigger_id)); ?>