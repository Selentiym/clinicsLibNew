<h1><?php echo CHtml::encode('Добавить нового врача'); ?></h1>
<br/>
<?php $this->renderPartial('//doctors/_form', array('model'=>$model)); ?>