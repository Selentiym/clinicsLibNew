<h1><?php echo CHtml::encode('Создать новое значение поля доктора <'.$object -> name .'>.'); ?></h1>

<?php $this->renderPartial('//doctorsfields/_form', array('model'=>$model, 'id' => $id)); ?>