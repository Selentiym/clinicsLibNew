<?php

/*Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        alert('213');
		$('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
		
        $('#clinics-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");*/
?>
<?php if(Yii::app()->user->hasFlash('nothingToUpload')): ?>
    <div class="alert-danger">
        <?php echo Yii::app()->user->getFlash('nothingToUpload'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('clinicExists')): ?>
    <div class="alert-warning">
        <?php echo Yii::app()->user->getFlash('clinicExists'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('errorsWhileImporting')): ?>
    <div class="alert-danger">
        <?php echo Yii::app()->user->getFlash('errorsWhileImporting'); ?>
    </div>
<?php endif; ?>


<?php if(Yii::app()->user->hasFlash('errorUpload')): ?>
    <div class="alert-danger">
        <?php echo Yii::app()->user->getFlash('errorUpload'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('successfullUpload')): ?>
    <div class="alert-success">
        <?php echo Yii::app()->user->getFlash('successfullUpload'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('errorTruncate')): ?>
    <div class="alert-danger">
        <?php echo Yii::app()->user->getFlash('errorTruncate'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('successfullClinicsImport')): ?>
    <div class="alert-success">
        <?php echo Yii::app()->user->getFlash('successfullClinicsImport'); ?>
    </div>
<?php endif; ?>

<h1><?php echo CHtml::encode('Перечень клиник'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новую' , Yii::app()->baseUrl.'/admin/clinicsCreate', array('class' => 'btn')); ?>
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'clinics-grid',
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
        array('name' => 'phone', 'header' => $model->getAttributeLabel('phone')),
        array('name' => 'site', 'header' => $model->getAttributeLabel('site')),

        array(
            'class'=>'CLinkColumn',
            'header'=>CHtml::encode('Цены'),
            'labelExpression'=>'CHtml::button("Редактировать",array("onclick"=>"document.location.href=\'".Yii::app()->createUrl("admin/ClinicsPricelists", array("id"=>$data->id))."\'"))',
            'urlExpression'=>'Yii::app()->createUrl("admin/ClinicsPricelists", array("id"=>$data->id))',
        ),
        /*array(
            'class'=>'CLinkColumn',
            'header'=>CHtml::encode('Услуги'),
            'labelExpression'=>'CHtml::button("Редактировать",array("onclick"=>"document.location.href=\'".Yii::app()->createUrl("admin/ClinicsServices", array("id"=>$data->id))."\'"))',
            'urlExpression'=>'Yii::app()->createUrl("admin/ClinicsServices", array("id"=>$data->id))',

        ),*/

        array(
            'class'=>'CLinkColumn',
            'header'=>CHtml::encode('Поля'),
            'labelExpression'=>'CHtml::button("Редактировать",array("onclick"=>"document.location.href=\'".Yii::app()->createUrl("admin/ClinicsFields", array("id"=>$data->id))."\'"))',
            'urlExpression'=>'Yii::app()->createUrl("admin/ClinicsFields", array("id"=>$data->id))',

        ),

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
)); ?>

<div class="row-fluid">
    <div class="span5">
        <?php echo CHtml::link('Импорт клиник', '', array('class' => 'btn btn-success', 'onclick'=> 'location.href="'.Yii::app() -> baseUrl.'/admin/googleDoc";')); ?>
        <?php //echo CHtml::link('Импорт клиник', '', array('class' => 'btn btn-success', 'onclick'=> 'javascript:showImportClinicsForm()')); ?>

    <!--<div>
        <?php //$this->renderPartial('_import_clinics'); ?>
    </div>-->
    </div>
    

    
    <!--<div class="span5">
        <?php //echo CHtml::link('Экспорт клиник', Yii::app()->controller->createUrl('admin/clinicsExportCsv'), array('class' => 'btn btn-warning')); ?>
    <div>
        <?php //$this->renderPartial('_export_clinics'); ?>
    </div>
    </div>-->
    
</div>    