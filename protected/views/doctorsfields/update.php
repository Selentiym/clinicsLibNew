<h1><?php echo CHtml::encode('Редактировать значение поля <'.$model->field->title.'> доктора <'.$model -> doctor -> name.'>.'); ?></h1>

<?php $this->renderPartial('//doctorsfields/_form', array('model'=>$model)); ?>