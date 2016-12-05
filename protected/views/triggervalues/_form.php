<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'trigger-values-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ));?>

        <div class="span6">

            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

            <div>
                <?php echo $form->labelEx($model,'trigger_id'); ?>
                <?php if(isset($trigger_id)) $model->trigger_id = $trigger_id; echo $form->textField($model, 'trigger_id', array('disabled'=>'disabled')); ?>
                <?php echo $form->error($model,'trigger_id'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'value'); ?>
                <?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'value'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'verbiage'); ?>
                <?php echo $form->textField($model,'verbiage',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'verbiage'); ?>
            </div>

            <div class="buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
            </div>

        <?php $this->endWidget(); ?>
       </div>
    </div><!-- form -->
</div>