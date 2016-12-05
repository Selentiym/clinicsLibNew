<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'clinics-fields-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ));?>

        <div class="span6">
            <?php if(Yii::app()->user->hasFlash('duplicateObjectsField')): ?>
                <div class="alert-danger">
                    <?php echo Yii::app()->user->getFlash('duplicateObjectsField'); ?>
                </div>
            <?php endif; ?>
            <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>
			<?php if ($model -> isNewRecord): ?>
            <div>
                <?php echo $form->labelEx($model,'field_id'); ?>
                <?php echo $form->dropDownList($model, 'field_id', CHtml::listData(Fields::model()->findAll('object_type = '.Objects::model() -> getNumber('clinics')), 'id', 'title')); ?>
                <?php echo $form->error($model,'field_id'); ?>
            </div>
            <?php endif; ?>
            <div>
                <?php echo $form->labelEx($model,'value'); ?>
                <?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'value'); ?>
            </div>


            <div class="buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
				<?php echo CHtml::link('Назад к полям' , Yii::app()->baseUrl.'/admin/clinicsFields/' . $model -> object_id, array('class' => 'btn')); ?>
            </div>

        <?php $this->endWidget(); ?>
       </div>
    </div><!-- form -->
</div>