<?php

/*Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        alert('213');
		$('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
		
        $('#MenuButtons-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");*/
?>

<h1><?php echo CHtml::encode('Пункты меню'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новый' , Yii::app()->baseUrl.'/admin/MenuButtonsCreate', array('class' => 'btn')); ?>
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'MenuButtons-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enablePagination' => true,
    'summaryText' => '',
    'template'=>'{pager}{items}',
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
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'url', 'header' => $model->getAttributeLabel('url')),
        array('name' => 'position', 'header' => $model->getAttributeLabel('position')),
        array('name' => 'level', 'header' => $model->getAttributeLabel('level')),
		
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}&nbsp;{delete}',
			'deleteConfirmation'=>"js:'Вы действительно хотите удалить пункт <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
			'buttons'=>array
			(
				'update' => array
				(
					'label'=> CHtml::encode('Редактировать'),
					'url'=>'Yii::app()->createUrl("admin/MenuButtonsUpdate", array("id"=>$data->id))',
				),
				'delete' => array
				(
					'label'=> CHtml::encode('Удалить'),
					'url'=>'Yii::app()->createUrl("admin/MenuButtonsDelete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>