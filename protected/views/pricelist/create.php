<?php $text = ($model -> object_type == Objects::model() -> getNumber('clinics') ) ? 'клиники'  : 'доктора'; ?>
<h1><?php echo CHtml::encode('Создать новую цену на услугу '.$text.' <'.$object -> name.'>'); ?></h1>

<?php $this->renderPartial('//pricelist/_form', array('model'=>$model, 'object_id' => $object_id)); ?>