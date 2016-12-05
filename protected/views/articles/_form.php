<?php
	Yii::app()->clientScript->registerScript('PreviewScript','
		$("#previewButton").click(function(){
			var form = $("#articles-form");
			var save_action = (form.attr("action")) ? form.attr("action") : "";
			var save_target = (form.attr("target")) ? form.attr("target") : "";
			form.attr("action","'.Yii::app() -> baseUrl.'/home/ArticlePreview");
			form.attr("target","_blank");
			//alert(form);
			form.submit();
			form.attr("action",save_action);
			form.attr("target",save_target);
		});
	', CClientScript::POS_READY );
	set_time_limit(500);
?>
<div class="row-fluid">

    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'articles-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

        <div class="span6">

            <?php if(Yii::app()->user->hasFlash('duplicateArticle')): ?>
                <div class="alert-danger">
                    <?php echo Yii::app()->user->getFlash('duplicateArticle'); ?>
                </div>
            <?php endif; ?>
            
            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>
            
            <?php echo CHtml::hiddenField('fileUpload', Yii::app()->createUrl("admin/fileUpload")); ?>
        <div>
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'verbiage'); ?>
            <?php echo $form->textField($model,'verbiage',array('size'=>20,'maxlength'=>20)); ?>
            <?php echo $form->error($model,'verbiage'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>
        
        <div>
            <?php echo $form->labelEx($model,'keywords'); ?>
            <?php echo $form->textArea($model,'keywords',array('size'=>60,'maxlength'=>2000,'id'=>'checkid')); ?>
            <?php echo $form->error($model,'keywords'); ?>
        </div>
        
        <div>
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>2000)); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>

		<div>
            <?php echo $form->labelEx($model,'level'); ?>
            <?php echo $form->dropDownList($model,'level', Articles::model() -> getLevelArray(),
				array (
					'ajax' => array (
						'type'=>'POST',   
						'dataType'=>'json',  
						'url'=>Yii::app()->createAbsoluteUrl('admin/ajaxgetparents'),
						'success'=>'function(data) { 
							if (data.parentList) { 
								$("#Articles_parent_id").html(data.parentList);
								$("#parents_block").show();
								$("#Articles_parent_id").chosen("destroy");
								$("#Articles_parent_id").chosen();
							} 
							else { 
								$("#Articles_parent_id").html("<option value =\'0\'></option>");
								$("#parents_block").hide(); 
							} 
						}',  
				))); //echo CHtml::dropDownList('article_type', 0, $radio_items); ?>
            <?php echo $form->error($model,'level'); ?>
        </div>
		<div id="parents_block" style="display: none;">
			<?php echo $form->labelEx($model,'parent_id'); ?>  
			<?php echo $form->dropDownList($model,'parent_id', array()); ?>

			<?php echo $form->error($model,'parent_id'); ?>  
		</div>
        <div>
            <?php echo $form->labelEx($model,'show_objects'); ?>
            <?php echo CHtml::activeRadioButtonList($model,'show_objects',array(1 => 'Показать', 0 => 'Не показать')); ?>
            <?php echo $form->error($model,'show_objects'); ?>
        </div>
		<div>
            <?php
            
			echo $form->labelEx($model,'trigger_value_id');
			
			$triggers = array_merge(array('0'=>''),CHtml::listData(TriggerValues::model()->findAll(), 'id', 'value'));
			//$triggers = CHtml::listData(TriggerValues::model()->findAll(), 'id', 'value');
			//print_r($triggers);
			echo CHtml::activeDropDownList(TriggerValues::model(),'id',$triggers, array('name'=>'triggers_array[]','multiple'=>'multiple','allow_single_deselect'=>'true'),array_map('trim', explode (';', $model->trigger_value_id)));
            ?>
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
							'valid_elements' => 'h2,h1,p[style|class],ul,li,table[border],tr,td,tbody,img[src|style],a[href],b,i,span[style|class],strong,em',
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

                        
            </div>
            <?php echo $form->error($model,'text'); ?>
        </div>
		<div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
            <?php echo CHtml::button('Посмотреть на сайте', array('id' => 'previewButton')); ?>
            <?php echo CHtml::button('Список статей', array('id' => 'articleList','onClick' => 'location.href = "'.Yii::app() -> baseUrl.'/admin/articles";')); ?>
        </div>
        <!-- Выводим генератор для search_id -->
		<?php  $this -> renderPartial('//searchid/triggerForm', array('id' => 'search_id_generator'))?>
        <br/>
        

    <?php $this->endWidget(); 

	?>
    </div>
    </div><!-- form -->
</div>