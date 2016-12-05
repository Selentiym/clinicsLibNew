<div class="row-fluid">

    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'menuButtons-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

        <div class="span6">
            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>
        <div>
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>50)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
		
		<div>
            <?php echo $form->labelEx($model,'url'); ?>
            <?php echo $form->textField($model,'url',array('size'=>50)); ?>
            <?php echo $form->error($model,'url'); ?>
        </div>
		
		<div>
            <?php echo $form->labelEx($model,'position'); ?>
            <?php echo $form->textField($model,'position',array('size'=>50)); ?>
            <?php echo $form->error($model,'position'); ?>
        </div>
		
		<div>
            <?php echo $form->labelEx($model,'level'); ?>
            <?php echo $form->dropDownList($model,'level', MenuButtons::model() -> getLevelArray(),
				array (
					'ajax' => array (
						'type'=>'POST',   
						'dataType'=>'json',  
						'url'=>Yii::app()->createAbsoluteUrl('admin/AjaxGetParentsMenuButtons'),
						'success'=>'function(data) { 
							if (data.parentList) { 
								$("#MenuButtons_parent_id").html(data.parentList);
								$("#parents_block").show();
								$("#MenuButtons_parent_id").chosen("destroy");
								$("#MenuButtons_parent_id").chosen();
							} 
							else { 
								$("#MenuButtons_parent_id").html("<option value =\'0\'></option>");
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
		

                        
        </div>
		<div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
        </div>
        

    <?php $this->endWidget(); 

	?>
    </div>
    </div><!-- form -->
</div>