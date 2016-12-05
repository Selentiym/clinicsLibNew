<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#comments-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1><?php echo CHtml::encode('Комментарии'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'comments-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enablePagination' => true,
    'ajaxUpdate'=>true,
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
        array('name' => 'object_id', 'header' => $model->getAttributeLabel('object_id')),
        array('name' => 'text', 'header' => $model->getAttributeLabel('text')),
        array('name' => 'create_at', 'header' => $model->getAttributeLabel('create_at')),
        array(
            'name'=>'approved',
            'type'=>'raw',
            'header'=>$model->getAttributeLabel('approved'),
            'value'=>'CHtml::ajaxLink(
                                    (($data->approved == 1)? CHtml::encode("Отклонить"): CHtml::encode("Одобрить")),
                                    Yii::app()->createUrl("admin/commentToggle"),
                                    array(
                                        "type"=>"POST",
                                        "dataType"=>"json",
                                        "data"=>array(
                                            "id"=> $data->id,
                                        ),
                                        "success"=>"js:function(data){
                                            if (data) {
                                                $(\"#comment_\"+data.id).text(data.text);
                                                $(\"#comment_\"+data.id).removeClass();
                                                $(\"#comment_\"+data.id).addClass(data.class);
                                            }
                                        }",
                                    ),
                                    array(
                                        "id" => "comment_" . $data->id,
                                        "class" => "btn " . (($data->approved == 1)? "btn-success": "btn-danger"),
                                    )
                                )'
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить комментарий <'+$(this).parent().parent().children(':nth-child(1)').text()+'>?'",
            'buttons'=>array
            (
              'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>'Yii::app()->createUrl("admin/commentDelete", array("id"=>$data->id))',
                ),

                /*
                'approved' => array(
                    'label' => "($data->approved == 1)? CHtml::encode('Отклонить'): CHtml::encode('Одобрить')",
                    'url' => 'Yii::app()->createUrl("admin/commentToggle", array("id"=>$data->id))',
                    'options' => array (
                            "class" => "btn",
                            "id" => 'comment_$data->id',
                            //"class" => "btn ({$data->approved} == 1)? 'btn-success': 'btn-danger')",
                           
                            'ajax'=> array(
                                        'type'=>'POST',
                                        'dataType'=>'json',
                                        'url'=>'js:$(this).attr("href")',
                                        'success' => 'js:function(data) { 
                                            if (data) {
                                                        $(\"#comment_\"+data.id).text(data.text);
                                                        $(\"#comment_\"+data.id).removeClass();
                                                        $(\"#comment_\"+data.id).addClass(data.class);
                                        }'
                             )
                      ),       
                ), */
            ),
        ),        
    ),
));
?>