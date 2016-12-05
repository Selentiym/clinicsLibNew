<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#articles-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo CHtml::encode('Перечень статей'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новую' , Yii::app()->baseUrl.'/admin/articleCreate', array('class' => 'btn')); ?>
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'articles-grid',
	'dataProvider'=>$model->search(),
    'enablePagination' => true,
    'summaryText' => '',
	'filter'=>$model,
	'columns'=>array(
        array('name' => 'id', 'header' => $model->getAttributeLabel('id')),
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'verbiage', 'header' => $model->getAttributeLabel('verbiage')),
        array('name' => 'parent_id', 'header' => $model->getAttributeLabel('parent_id'), 'value' => '($data->parent_id == 0)? CHtml::encode("0 (Корневая статья)"): Articles::model() -> findByPk($data->parent_id) -> name'),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить статью <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/articleUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/articleDelete", array("id"=>$data->id))',
                ),
            ),

        ),
	),
)); ?>
