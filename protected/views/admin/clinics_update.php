<h1><?php echo CHtml::encode('Редактировать данные о клинике <'); ?> <?php echo $model->name; ?> ></h1>
<br/>
<?php $this->renderPartial('//clinics/_form', array('model'=>$model)); ?>