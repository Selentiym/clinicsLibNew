<div class="row-fluid">

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'filters-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

        <div class="span6">

        <p class="note"> <?php echo CHtml::encode('Поля с '); ?> <span class="required">*</span> <?php echo CHtml::encode('обязательны для заполнения'); ?></p>

        <div>
            <?php echo $form->labelEx($model,'speciality_id'); ?>
            <?php 
                $speciality = Triggers::model()->find(array('condition' => 'verbiage = "speciality"'));
                $specialities= CHtml::listData(TriggerValues::model()->findAll(array('condition' => 'trigger_id = :speciality_id', 'params'=>array(':speciality_id' => (int)$speciality->id))), 'id', 'value');
                echo $form->dropDownList($model, 'speciality_id', $specialities);
            ?>
            <?php echo $form->error($model,'speciality_id'); ?>
        </div>
        
        <div>
            <?php echo $form->labelEx($model,'fields'); ?>

            <?php
                $triggers= CHtml::listData(Triggers::model()->findAll(), 'id', 'name');
    			//$triggers= CHtml::listData(TriggerValues::model()->findAll(), 'id', 'value');
				echo CHtml::activeDropDownList(Triggers::model(),'id',$triggers, array('name'=>'triggers_array[]','multiple' => 'multiple'),array_map('trim', explode (';', $model->fields)));
                /*$this->widget('application.extensions.EchMultiSelect.EchMultiSelect', array(
                    'name' => 'triggers_array',
                    'data' => $triggers,
                    'value' => array_map('trim', explode (';', $model->fields)),
                    'options' => array(
                        'selectedText' =>Yii::t('EchMultiSelect.EchMultiSelect','# выбрано'),
                        'autoOpen'=>false,
                        'filter'=> false,
                        'noneSelectedText'=> Yii::t('EchMultiSelect.EchMultiSelect','Выберите триггер..'),
                        'checkAllText' => Yii::t('EchMultiSelect.EchMultiSelect','Выбрать все'),
                        'uncheckAllText' => Yii::t('EchMultiSelect.EchMultiSelect','Очистить все'),
                    ),
                ));//*/
            ?>
            <?php echo $form->error($model,'fields'); ?>
        </div>
              
        <br/>
        <div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div>
    </div><!-- form -->
</div>