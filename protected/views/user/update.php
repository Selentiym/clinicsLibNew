<h1><?php echo CHtml::encode('Редактировать пользователя <' . $model->username . '>'); ?></h1>

<?php $this->renderPartial('//user/_form', array('model'=>$model)); ?>