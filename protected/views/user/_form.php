<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

        <div class="span6">
            <?php if(Yii::app()->user->hasFlash('duplicateUser')): ?>
                <div class="alert-danger">
                    <?php echo Yii::app()->user->getFlash('duplicateUser'); ?>
                </div>
            <?php endif; ?>
                        
            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>
        <div>
            <?php echo $form->labelEx($model,'username'); ?>
            <?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'password'); ?>
            <div class="row-fluid">
                <?php echo ($model->password != '')? $form->passwordField($model,'password', array('disabled' => 'disabled')): $form->textField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
                <?php //echo CHtml::label(CHtml::encode('Изменить'), 'changePassword')?>
                <?php //echo CHtml::checkBox('changePassword', false)?>
            </div>    
            <?php echo $form->error($model,'password'); ?>
        </div>
        
        <div>
            <?php echo $form->labelEx($model,'clinic_id'); ?>
            <?php $clinics = CHtml::listData(clinics::model()->findAll(), 'id', 'name');
                  //$menu_items = array_map('trim', explode(';', $leftside_menu->value));
                  echo $form->dropDownList($model,'clinic_id', $clinics, array('empty'=> Chtml::encode('Выберите клинику..')));
            ?>
            <?php echo $form->error($model,'clinic_id'); ?>
        </div>
       
        <br/>
        <div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div>
    </div><!-- form -->
</div>