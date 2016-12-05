<?php $text = ($model -> object_type == Objects::model() -> getNumber('clinics') ) ? 'клиники <'. $model -> clinic -> name.'>' : 'доктора <'. $model -> doctor -> name.'>'; ?>
<h1><?php echo CHtml::encode('Редактировать цену на услугу <' . $model->name . '> '.$text); ?></h1>

<?php $this->renderPartial('//pricelist/_form', array('model'=>$model)); ?>