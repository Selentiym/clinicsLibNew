<h1><?php echo CHtml::encode('Создать новое значение поля клиники <'.$object -> name .'>.'); ?></h1>

<?php $this->renderPartial('//clinicsfields/_form', array('model'=>$model, 'clinic_id' => $clinic_id)); ?>