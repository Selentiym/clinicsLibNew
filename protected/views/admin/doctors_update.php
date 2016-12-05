<h1><?php echo CHtml::encode('Редактировать данные о докторе <'); ?> <?php echo $model->name; ?> ></h1>
<br/>
<?php $this->renderPartial('//doctors/_form', array('model'=>$model)); ?>