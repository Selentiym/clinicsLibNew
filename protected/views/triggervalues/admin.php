<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#trigger-values-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo CHtml::encode('Перечень значений тригера <' . $trigger->name .'>'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новое' , Yii::app()->baseUrl.'/admin/triggerValueCreate/' . $trigger_id, array('class' => 'btn')); ?>
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trigger-values-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'enablePagination' => true,
    'summaryText' => '',
	'columns'=>array(
        array('name' => 'id', 'header' => $model->getAttributeLabel('id')),
        array('name' => 'trigger_id', 'header' => $model->getAttributeLabel('trigger_id')),
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
                    'url'=>'Yii::app()->createUrl("admin/triggerValueUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/triggerValueDelete", array("id"=>$data->id))',
                ),
            ),

		),
	),
)); ?>
