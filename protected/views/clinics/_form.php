    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'clinics-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>
    
    <?php if(Yii::app()->user->hasFlash('successfullSave')): ?>
        <div class="alert-success">
            <?php echo Yii::app()->user->getFlash('successfullSave'); ?>
        </div>
    <?php endif; ?>

<div class="row-fluid">
    <h3> <?php echo Chtml::encode('Основные поля'); ?></h3>
    <hr><br/>
    
    <div class="span5">

        <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

        <div>
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>500)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'verbiage'); ?>
            <?php echo $form->textField($model,'verbiage',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'verbiage'); ?>
        </div>
        
        <div>
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>
        
        <div>
            <?php echo $form->labelEx($model,'keywords'); ?>
            <?php echo $form->textField($model,'keywords',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'keywords'); ?>
        </div>
        
        <div>
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'phone'); ?>
            <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'phone'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'mrt'); ?>
            <?php echo $form->textField($model,'mrt',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'mrt'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'kt'); ?>
            <?php echo $form->textField($model,'kt',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'kt'); ?>
        </div>
		
        <div>
            <?php echo $form->labelEx($model,'experience'); ?>
            <?php echo $form->textField($model,'experience',array('size'=>10,'maxlength'=>5)); ?>
            <?php echo $form->error($model,'experience'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'fax'); ?>
            <?php echo $form->textField($model,'fax',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'fax'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'address'); ?>
            <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'address'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'metro_station'); ?>

            <?php
                $metro= CHtml::listData(Metro::model()->findAll(), 'id', 'name');
				
				echo CHtml::activeDropDownList(Metro::model(),'id', $metro,array('name' => 'metro_station_array[]','multiple' => 'multiple'),array_map('trim', explode (';', $model->metro_station)));
            ?>
            <?php echo $form->error($model,'metro_station'); ?>
        </div>
        <br/>

        <div>
            <?php echo $form->labelEx($model,'district'); ?>

            <?php
            $district= CHtml::listData(Districts::model()->findAll(), 'id', 'name');
			
			echo CHtml::activeDropDownList(Districts::model(),'id', $district,array('name' => 'district_array[]','multiple' => 'multiple'),array_map('trim', explode (';', $model->district)));
			
            /*$this->widget('application.extensions.EchMultiSelect.EchMultiSelect', array(
                'name' => 'district_array',
                'data' => $district,
                'value' => array_map('trim', explode (';', $model->district)),
                'options' => array(
                    'selectedText' =>Yii::t('EchMultiSelect.EchMultiSelect','# выбрано'),
                    'autoOpen'=>false,
                    'filter'=> false,
                    'noneSelectedText'=> Yii::t('EchMultiSelect.EchMultiSelect','Выберите район..'),
                    'checkAllText' => Yii::t('EchMultiSelect.EchMultiSelect','Выбрать все'),
                    'uncheckAllText' => Yii::t('EchMultiSelect.EchMultiSelect','Очистить все'),
                ),
            ));*/
            ?>
            <?php echo $form->error($model,'district'); ?>
        </div>
        <br/>

        <div>
            <?php echo $form->labelEx($model,'site'); ?>
            <?php echo $form->textField($model,'site',array('size'=>60,'maxlength'=>1000)); ?>
            <?php echo $form->error($model,'site'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'working_days'); ?>
            <?php echo $form->textField($model,'working_days',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'working_days'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'working_hours'); ?>
            <?php echo $form->textField($model,'working_hours',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'working_hours'); ?>
        </div>

    </div>

    <div class="span6">

        <div>
            <?php echo $form->labelEx($model,'rating'); ?>
            <?php echo (!$this->isSuperAdmin())? $form->textField($model,'rating', array('disabled' => 'disabled')): $form->textField($model,'rating'); ?>
            <?php echo $form->error($model,'rating'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'logo'); ?>
            <?php
                if (!empty($model->logo)) {
                    //$logo = Yii::app()->baseUrl.'/images/clinics/' . $model->id . '/' .$model->logo;
                    $logo = $model -> giveImageFolderRelativeUrl() . $model->logo;
                    echo '<div id="logo">' . CHtml::ajaxLink('<i class="icon-remove"></i>', CController::createUrl('admin/propDelete/' . $model->id), array('type'=> 'POST', 'data'=>array('model' => 'clinic', 'prop' => 'logo'), 'success' => 'js: $("#logo").hide()'))
                     . CHtml::image($logo, CHtml::encode('Логотип'),
                        array('style' => 'max-width:172px;max-height:200px; padding: 8px 0px 8px 15px;')) . '</div>';
                }
            ?>
            <?php echo $form->fileField($model, 'logo'); ?>
            <?php echo $form->error($model,'logo'); ?>
        </div>
		<div>
            <?php echo "Работники"; ?>
            <?php
			$doctors_all = CHtml::listData(doctors::model()->findAll(), 'id', 'name');
			echo CHtml::activeDropDownList(doctors::model(),'id',$doctors_all, array('name'=>'clinics[doctorsInput]','multiple' => 'multiple'),CHtml::giveAttributeArray($model -> doctors, 'id'));
            ?>
            <?php echo $form->error($model,'doctorsInput'); ?>
        </div>
        <div>
            <?php echo $form->labelEx($model,'triggers'); ?>

            <?php
			$triggers= CHtml::listData(TriggerValues::model()->findAll(), 'id', 'value');
			echo CHtml::activeDropDownList(TriggerValues::model(),'id',$triggers, array('name'=>'triggers_array[]','multiple' => 'multiple'),array_map('trim', explode (';', $model->triggers)));
            ?>
            <?php echo $form->error($model,'triggers'); ?>
        </div>
        <div>
            Партнер
            <?php
                echo CHtml::activeCheckBox($model,'partner');
            ?>
        </div>
        <div>
            Скрыть
            <?php
                echo CHtml::activeCheckBox($model,'ignore_clinic');
            ?>
        </div>
        <br/>

        <div>
            <?php echo $form->labelEx($model,'pictures'); ?>
            <?php
                if (!empty($model->pictures)) {
                    echo '<div id="pictures">';
                    $pictures = array_map('trim', explode(';', $model->pictures));
                    $counter = 0;
                    foreach ($pictures as $picture) {
                        $counter++;
                        $picture_display = $model -> giveImageFolderRelativeUrl() . $picture;
                        echo '<div id="picture' . $counter. '">' . CHtml::ajaxLink('<i class="icon-remove"></i>', CController::createUrl('admin/propDelete/' . $model->id), array('type'=> 'POST', 'data'=>array('model' => 'clinic', 'prop' => 'img',  'prop_value' => $picture), 'success' => 'js: $("#picture' . $counter . '").hide()')) 
                        . CHtml::image($picture_display, $picture, array('style' => 'max-width:172px;max-height:200px; padding: 8px 0px 8px 15px;', )) . '</div>';
                    }
                    echo '</div>';
                }
            ?>
            <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
            <?php
                $this->widget('CMultiFileUpload', array(
                'name' => 'images',
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => CHtml::encode('Такой файл уже добавлен'), 
                'denied' => Chtml::encode('Недопустимый формат файла'), 
                ));
            ?>
            <?php echo $form->error($model,'pictures'); ?>
        </div>


        <div>
            <?php echo $form->labelEx($model,'map_coordinates'); ?>
            <?php echo $form->textField($model,'map_coordinates',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'map_coordinates'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'text'); ?>
            <div class="controls">
			
			<?php
				 $this->widget('application.extensions.tinymce.TinyMce',
                    array(
                        'model'=>$model,
                        'attribute'=>'text',
                        //'editorTemplate'=>'full',
                        'skin'=>'cirkuit',
                        
                        //'useCompression'=>false,
                        'settings'=> array(
                            'mode' =>"textareas",
                            'theme' => 'advanced',
                            'skin' => 'o2k7',
                            'theme_advanced_toolbar_location'=>'top',
                            'plugins' => 'add_margin,advimage,spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,table,template,paste',
							'paste_remove_styles' => true,
							'paste_remove_spans' => true,
							'cleanup' => true,
							'valid_elements' => 'div,h2,h1,p[style|class],ul,li,table[border],tr,td,tbody,img[src|style],a[href],b,i,span[style|class],strong,em',
							'theme_advanced_fonts' => 'Arial=arial,helvetica,sans-serif;Times New Roman=times new roman,times',
							'paste_word_valid_elements' => "p,ul,li,table,tr,td,tbody,a[href]",
							"content_css" => Yii::app() -> baseUrl."/css/tinymce.css, ".Yii::app() -> baseUrl."/css/custom.css, ".Yii::app() -> baseUrl."/css/styles.css",
							//http://www.tinymce.com/wiki.php/Configuration3x:formats - список параметров для style_formats
							'style_formats' => array(
								array('title' => 'Жирным','block' => 'p','classes' => 'checkbold'),
								array('title' => 'check2','block' => 'p','classes' => 'check2_class')
							),
							//'theme_advanced_font_sizes' => "Big text=30px,Small text=small,My Text Size=.mytextsize",
							//'theme_advanced_styles' => "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1",
							'theme_advanced_buttons1' => "mysplitbutton,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,removeformat,|,tablecontrols",
							'theme_advanced_buttons2' => "cut,copy,paste,pastetext,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
							//'theme_advanced_buttons2' => "paste,pastetext",
							'theme_advanced_buttons3' => "styleselect,formatselect,fontselect,fontsizeselect",
							'theme_advanced_buttons4' => "",
							//'theme_advanced_buttons3' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                            'theme_advanced_toolbar_location' => 'top',
                            'theme_advanced_toolbar_align' => 'left',
                            'theme_advanced_statusbar_location' => 'bottom',
                            'theme_advanced_resizing_min_height' => 30,
                            'height' => 300,
                            
                        ),
                        
                        'fileManager' => array(
                                    'class' => 'application.extensions.elFinder.TinyMceElFinder',
                                    'popupConnectorRoute' => 'elfinder/elfinderTinyMce', // relative route for TinyMCE popup action
                                    'popupTitle' => "Files",
                             ), 
                        'htmlOptions'=>array('rows'=>5, 'cols'=>30, 'class'=>'tinymce'),
                    ));
			?>
			
			
			
			
                <?php /*$this->widget('application.extensions.tinymce.TinyMce',
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
                    )); */?>

                        
            </div>
            <?php echo $form->error($model,'text'); ?>
            <br/>
        </div>

        <div>
            <?php echo $form->labelEx($model,'audio'); ?>
            <?php
                echo (!empty($model->audio)? 
                    '<div id="audio">' . CHtml::ajaxLink('<i class="icon-remove"></i>', CController::createUrl('admin/propDelete/' . $model->id), array('type'=> 'POST', 'data'=>array('model' => 'clinic', 'prop' => 'audio'), 'success' => 'js: $("#audio").hide()')) . ' '. $model->audio . '</div><br/>'
                    : '');
            ?>
            <?php echo CHtml::activeFileField($model,'audio'); ?>
            <?php echo $form->error($model,'audio'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'video'); ?>
            <?php echo $form->textField($model,'video',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'video'); ?>
        </div>

    </div>

</div>

<?php if ($model->fields) : ?>
    <div class="row-fluid">
        <hr>
        <h3> <?php echo Chtml::encode('Дополнительные поля'); ?></h3>
        <hr><br/>
        
        <div class="span5">
            <?php foreach ($model->fields as $field): //var_dump($field->field->title);  ;?>
                <div>
                    <?php echo CHtml::label($field->field->title, ''); ?>
                    <?php echo CHtml::textField("clinics[Additional][".$field->id."]", $field->value, array('size'=>60,'maxlength'=>500)); ?>
                    <?php //echo CHtml::hiddenField("clinics[Additional][".$field->field->name."][rel_id]", $field->id); ?>
                </div>
            <?php endforeach; ?>    
        </div>    
    </div>
<?php endif; ?>

<div class="buttons pull-right">
    <?php echo CHtml::submitButton(CHtml::encode('Сохранить')); ?>
</div>
        
<?php $this->endWidget(); ?>

<script>
    function chooseFile() {
        $("#pictures").click();
    }
</script>