<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#clinics-fields-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo CHtml::encode('Перечень полей клиник <' . $clinic->name .'>'); ?></h1>
<br/>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новое' , Yii::app()->baseUrl.'/admin/clinicsfieldsCreate/' . $clinic_id, array('class' => 'btn')); ?>
</p>
<br/>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clinics-fields-grid',
	'dataProvider'=>$model->search2('clinics'),
	'filter'=>$model,
    'enablePagination' => true,
    'summaryText' => '',
	'columns'=>array(
        'id',
        //array('name' => 'clinic.name', 'header' => $model->getAttributeLabel('clinic_id')),
        array('name' => 'field.title', 'header' => $model->getAttributeLabel('field_id')),
        array('name' => 'value', 'header' => $model->getAttributeLabel('value')),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить значение <'+$(this).parent().parent().children(':nth-child(3)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/clinicsFieldsUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/clinicsFieldsDelete", array("id"=>$data->id))',
                ),
            ),

		),
	),
)); ?>
