<h1><?php echo CHtml::encode('Создать новую услугу для клиники <'.$object -> name.'>.'); ?></h1>

<?php $this->renderPartial('//services/_form', array('model'=>$model, 'object_id' => $object_id)); ?>