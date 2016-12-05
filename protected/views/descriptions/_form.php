<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'descriptions-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ));?>

        <div class="span6">
            
            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>
         
            <div>
                <?php echo $form->labelEx($model,'object_type'); ?>
                <?php echo $form->dropDownList($model, 'object_type', CHtml::listData(Objects::model()->findAll(), 'id', 'name')); ?>
                <?php echo $form->error($model,'object_type'); ?>
            </div>
			
			<div>
            <?php echo $form->labelEx($model,'triggers'); ?>

            <?php
				$triggers= CHtml::listData(TriggerValues::model()->findAll(), 'id', 'value');
				echo CHtml::activeDropDownList(TriggerValues::model(),'id',$triggers, array('name'=>'triggers_array[]','multiple' => 'multiple'),array_map('trim', explode (';', $model->trigger_values)));
            ?>
            <?php echo $form->error($model,'triggers'); ?>
			</div>
			
			<?php echo $form->labelEx($model,'text'); ?>
            <div class="controls">
                <?php $this->widget('application.extensions.tinymce.TinyMce',
                    array(
                        'model'=>$model,
                        'attribute'=>'text',
                        //'editorTemplate'=>'full',
                        'skin'=>'cirkuit',
                        
                        //'useCompression'=>false,
                        'settings'=> array(
                            'mode' =>"textareas",
                            'theme' => 'advanced',
                            'skin' => 'cirkuit',
                            'theme_advanced_toolbar_location'=>'top',
                            'plugins' => 'advimage,spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,template',
                            'theme_advanced_buttons1' => 'formatselect,forecolor,|,bold,italic,strikethrough,|,bullist,numlist,|,fontselect fontsizeselect,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,image',
                            'theme_advanced_buttons2' => '',
                            'theme_advanced_buttons3' => '',
                            'theme_advanced_toolbar_location' => 'top',
                            'theme_advanced_toolbar_align' => 'left',
                            'theme_advanced_statusbar_location' => 'bottom',
                            'theme_advanced_resizing_min_height' => 30,
                            'height' => 300,
                            'width' => 100,
                            //'file_browser_callback' => 'openmanager',
                            //'open_manager_upload_path' => CHtml::encode(Yii::app()->basePath) . '/../images/uploads/',
                            //'relative_urls' => false,
                            
                        ),
                        
                        'fileManager' => array(
                                    'class' => 'application.extensions.elFinder.TinyMceElFinder',
                                    'popupConnectorRoute' => 'elfinder/elfinderTinyMce', // relative route for TinyMCE popup action
                                    'popupTitle' => "Files",
                             ), 
                        'htmlOptions'=>array('rows'=>5, 'cols'=>15, 'class'=>'tinymce'),
                    )); ?>

                        
            </div>
            <?php echo $form->error($model,'text'); ?>
			
            <div class="buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
            </div>

        <?php $this->endWidget(); ?>
       </div>
    </div><!-- form -->
</div>