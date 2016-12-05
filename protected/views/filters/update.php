<?php $word = $model -> object_type == Objects::model() -> getNumber('clinics') ? 'клиник' : 'докторов'; ?>
<h1><?php echo CHtml::encode('Редактировать фильтр '.$word); ?></h1>

<?php $this->renderPartial('//filters/_form', array('model'=>$model)); ?>