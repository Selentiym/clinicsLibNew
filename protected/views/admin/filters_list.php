<?php
$modelName = Objects::model() -> getName($model -> object_type);
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#fields-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
$word = $modelName == 'clinics' ? 'клиник' : 'докторов';
?>

<h1><?php echo CHtml::encode('Перечень фильтров для '.$word); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новый' , Yii::app()->baseUrl.'/admin/'.$modelName.'FilterCreate', array('class' => 'btn')); ?>
</p>
<br/>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'filters-grid',
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
        array('name' => 'speciality.value', 'header' => $model->getAttributeLabel('speciality_id')),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить фильтр для специализации <'+$(this).parent().parent().children(':nth-child(1)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>'Yii::app()->createUrl("admin/filterUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/filterDelete", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>
