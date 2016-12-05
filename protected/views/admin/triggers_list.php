<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#triggers-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>


<h1><?php echo CHtml::encode('Перечень триггеров'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новый' , Yii::app()->baseUrl.'/admin/triggerCreate', array('class' => 'btn')); ?>
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'triggers-grid',
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
            'class'=>'CLinkColumn',
            'header'=>CHtml::encode('Значения'),
            'labelExpression'=>'CHtml::button("Редактировать",array("onclick"=>"document.location.href=\'".Yii::app()->createUrl("admin/triggerValues", array("id"=>$data->id))."\'"))',
            'urlExpression'=>'Yii::app()->createUrl("admin/triggerValues", array("id"=>$data->id))',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить триггер <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/triggerUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/triggerDelete", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>
