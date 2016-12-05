<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'price-list-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ));?>

        <div class="span6">

            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

            <?php echo $form->errorSummary($model); ?>

            <div>
                <?php echo $form->labelEx($model,'object_id'); ?>
                <?php if(isset($object_id)) $model->object_id = $object_id; echo $form->textField($model, 'object_id', array('disabled'=>'disabled')); ?>
                <?php echo $form->error($model,'object_id'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model,'price'); ?>
                <?php echo $form->textField($model,'price'); ?>
                <?php echo $form->error($model,'price'); ?>
            </div>

            <div class="buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
				<?php echo CHtml::link('Назад к ценам' , Yii::app()->baseUrl.'/admin/'.Objects::model() -> getName($model->object_type).'Pricelists/' . $model -> object_id, array('class' => 'btn')); ?>
            </div>

        <?php $this->endWidget(); ?>
       </div>
    </div><!-- form -->
</div>