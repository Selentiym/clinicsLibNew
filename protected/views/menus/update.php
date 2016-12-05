<h1><?php echo CHtml::encode('Редактировать категорию <' . $model->name . '>'); ?></h1>

<?php $this->renderPartial('//menus/_form', array('model'=>$model)); ?>