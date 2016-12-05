<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#users-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1><?php echo CHtml::encode('Перечень пользователей'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить нового' , Yii::app()->baseUrl.'/admin/userCreate', array('class' => 'btn')); ?>
</p>
<br/>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'users-grid',
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
        array('name' => 'username', 'header' => $model->getAttributeLabel('username')),
        array('name' => 'clinic.name', 'header' => $model->getAttributeLabel('clinic_id')),
        array('name' => 'active', 'header' => $model->getAttributeLabel('active')),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить пользователя <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/userUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/userDelete", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>
