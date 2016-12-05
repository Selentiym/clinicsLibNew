<h1><?php echo CHtml::encode('Создать новый триггер'); ?></h1>

<?php $this->renderPartial('//triggers/_form', array('model'=>$model)); ?>

<?php CustomFlash::showFlashes(); ?>