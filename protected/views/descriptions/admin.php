<?php

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#descriptions-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1><?php echo CHtml::encode('Перечень описаний к набору триггеров'); ?></h1>
<br/>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новое' , Yii::app()->baseUrl.'/admin/DescriptionCreate/', array('class' => 'btn')); ?>
</p>
<br/>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'descriptions-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'enablePagination' => true,
    'summaryText' => '',
	'columns'=>array(
        'id',
        //array('name' => 'clinic.name', 'header' => $model->getAttributeLabel('clinic_id')),
        array('name' => 'trigger_values', 'header' => $model->getAttributeLabel('field_id'), 'value' => '$data -> giveTriggerString()'),
        //array('name' => 'value', 'header' => $model->getAttributeLabel('value')),
        array('name' => 'searchId', 'header' => 'search_id'),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить описание <'+$(this).parent().parent().children(':nth-child(3)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/DescriptionUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/DescriptionDelete", array("id"=>$data->id))',
                ),
            ),

		),
	),
)); //*/?>
<?php /*$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'descriptions-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enablePagination' => true,
    'summaryText' => '',
    'template'=>'{pager}{items}',
	'ajaxUpdate' => true,
    'pager' => array(
        'firstPageLabel'=>'<<',
        'prevPageLabel'=>'<',
        'nextPageLabel'=>'>',
        'lastPageLabel'=>'>>',
        'maxButtonCount'=>'10',
        'header'=>'<span>Перейти на страницу:</span>',
    ),
    'columns'=>array(
        'id',
        array('name' => 'trigger_values', 'header' => $model->getAttributeLabel('trigger_values')),
        array('name' => 'searchId', 'header' => $model->getAttributeLabel('search_id')),
		array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить клинику <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/clinicUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/clinicsDelete", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); */?>
