<h1><?php echo CHtml::encode('Редактировать статью <' . $model->name . '>'); ?></h1>

<?php $this->renderPartial('//articles/_form', array('model'=>$model, 'menuLevel' => $menuLevel)); ?>