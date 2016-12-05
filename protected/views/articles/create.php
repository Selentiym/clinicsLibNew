<h1><?php echo CHtml::encode('Создать статью'); ?></h1>

<?php $this->renderPartial('//articles/_form', array('model'=>$model, 'menuLevel' => $menuLevel)); ?>