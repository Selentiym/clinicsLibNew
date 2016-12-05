<h1><?php echo CHtml::encode('Редактировать значение поля <'.$model->field->title.'> клиники <'.$model -> clinic -> name.'>.'); ?></h1>

<?php $this->renderPartial('//clinicsfields/_form', array('model'=>$model)); ?>