<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#services-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$word = $object -> type == Objects::model() -> getNumber('clinics') ? 'клиники' : 'доктора' ;
?>

<h1><?php echo CHtml::encode('Перечень услуг '.$word.' <' . $object->name .'>'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новую' , Yii::app()->baseUrl.'/admin/'.get_class($object).'ServiceCreate/' . $object_id, array('class' => 'btn')); ?>
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'services-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'enablePagination' => true,
    'summaryText' => '',
	'columns'=>array(
            array('name' => 'id', 'header' => $model->getAttributeLabel('id')),
            //array('name' => 'object_id', 'header' => $model->getAttributeLabel('object_id')),
            //array('name' => 'object_type', 'header' => $model->getAttributeLabel('object_type')),
            array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
            array('name' => 'price_from', 'header' => $model->getAttributeLabel('price_from')),

            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}&nbsp;{delete}',
                'deleteConfirmation'=>"js:'Вы действительно хотите удалить услугу <'+$(this).parent().parent().children(':nth-child(4)').text()+'>?'",
                'buttons'=>array
                (
                    'update' => array
                    (
                        'label'=> CHtml::encode('Редактировать'),
                        'url'=>'Yii::app()->createUrl("admin/'.get_class($object).'ServiceUpdate", array("id"=>$data->id))',
                    ),
                    'delete' => array
                    (
                        'label'=> CHtml::encode('Удалить'),
                        'url'=>'Yii::app()->createUrl("admin/serviceDelete", array("id"=>$data->id))',
                    ),
                ),

            ),
	),
)); ?>
