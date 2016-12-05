<h1><?php echo CHtml::encode('Добавить новую клинику'); ?></h1>
<br/>
<?php $this->renderPartial('//clinics/_form', array('model'=>$model)); ?>