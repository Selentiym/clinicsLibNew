<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#menus-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>


<h1><?php echo CHtml::encode('Перечень категорий статей'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новую категорию' , Yii::app()->baseUrl.'/admin/menuCreate', array('class' => 'btn')); ?>
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'menus-grid',
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
        array('name' => 'verbiage', 'header' => $model->getAttributeLabel('verbiage')),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить категорию <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/menuUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/menuDelete", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>