<?php $text = ($model -> object_type == Objects::model() -> getNumber('clinics') ) ? 'клиники <'. $model -> clinic -> name.'>' : 'доктора <'. $model -> doctor -> name.'>'; ?>
<h1><?php echo CHtml::encode('Редактировать услугу <' . $model->name . '> '.  $text); ?></h1>

<?php $this->renderPartial('//services/_form', array('model'=>$model)); ?>