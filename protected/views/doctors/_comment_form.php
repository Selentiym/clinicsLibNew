<!-- HIDDEN COMMENT FORM-->
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'comment-form-' . $object_id,
        'action'=> Yii::app()->baseUrl.'/doctors/comment',
        //'clientOptions'=>array(
         //   'validateOnSubmit'=>true,
        //),
        'focus'=>array($model,'text'),
        'htmlOptions' => array(
            'style' => $isNew ? 'display: none': ''
        )
    )); ?>

    <?php echo CHtml::hiddenField('object_id', $object_id); ?>
    <?php echo CHtml::hiddenField('verbiage', $verbiage); ?>

    <div class="row-fluid">
            <div>
                    <?php $this->widget('application.extensions.tinymce.TinyMce',
                        array(
                            'model'=>$model,
                            'attribute'=>'text',
                            'skin'=>'cirkuit',
                            
                            'settings'=> array(
                                'mode' =>"textareas",
                                'theme' => 'advanced',
                                'skin' => 'cirkuit',
                                'theme_advanced_toolbar_location'=>'top',
                                'plugins' => 'advimage,spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,template',
                                'theme_advanced_buttons1' => 'formatselect,forecolor,|,bold,italic,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,image',
                                'theme_advanced_buttons2' => '',
                                'theme_advanced_buttons3' => '',
                                'theme_advanced_toolbar_location' => 'top',
                                'theme_advanced_toolbar_align' => 'left',
                                'theme_advanced_statusbar_location' => 'bottom',
                                'theme_advanced_resizing_min_height' => 30,
                                'height' => 300,
                                'width' => '100%',
                                
                            ),
                            
                            'fileManager' => array(
                                        'class' => 'application.extensions.elFinder.TinyMceElFinder',
                                        'popupConnectorRoute' => 'elfinder/elfinderTinyMce', // relative route for TinyMCE popup action
                                        'popupTitle' => "Files",
                                 ), 
                            'htmlOptions'=>array('rows'=>5, 'cols'=>15, 'class'=>'tinymce'),
                        )); ?>    
                        <br/>
                         <?php echo $form->error($model,'text'); ?>                   
                </div>
                <div>
                    <?php echo $form->labelEx($model,'user_first_name'); ?>
                    <?php echo $form->textField($model,'user_first_name',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'user_first_name'); ?>
                </div>      
                <div>
                    <?php echo $form->labelEx($model,'user_last_name'); ?>
                    <?php echo $form->textField($model,'user_last_name',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'user_last_name'); ?>
                </div>     
        <br/>                                 
        <div>
            <?php echo CHtml::htmlButton(CHtml::encode('Отправить'), array('class'=>'btn btn-info', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(CHtml::encode('Отменить'), array('class'=>'btn btn-default', )); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>
