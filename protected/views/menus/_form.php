<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'menus-form',
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
            <?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div>
            <?php echo $form->labelEx($model,'verbiage'); ?>
            <?php echo $form->textField($model,'verbiage',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'verbiage'); ?>
        </div>
              
        <br/>
        <div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div>
    </div><!-- form -->
</div>