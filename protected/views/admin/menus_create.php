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
    
        <div class="span5">
            
            <?php if(Yii::app()->user->hasFlash('errorUploadTop')): ?>
                <div class="alert-danger">
                    <?php echo Yii::app()->user->getFlash('errorMenuAdd'); ?>
                </div>
            <?php endif; ?>
            
            <?php if(Yii::app()->user->hasFlash('successfullUploadTop')): ?>
                <div class="alert-success">
                    <?php echo Yii::app()->user->getFlash('successfullMenuAdd'); ?>
                </div>
            <?php endif; ?>
    
            <div class="row-fluid">
                <?php echo $form->labelEx($model,'level'); ?>
                <?php //$menu_items = CHtml::listData(Options::model()->findAll("name like :search", array(':search'=>'%'. '_menu' .'%')), 'id', 'verbiage');
                      //$menu_items = array_map('trim', explode(';', $leftside_menu->value));
                      //echo $form->dropDownList($model,'menu_level', $menu_items, array('empty'=> Chtml::encode('Выберите уровень меню..')));
                ?>
                <?php echo $form->error($model,'level'); ?>
            </div>
        
            <div class="row-fluid">
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>20)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>

            <div class="row-fluid">
                <?php echo $form->labelEx($model,'verbiage'); ?>
                <?php echo $form->textField($model,'verbiage',array('size'=>20,'maxlength'=>20)); ?>
                <?php echo $form->error($model,'verbiage'); ?>
            </div>
            
            <div class="buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? CHtml::encode('Создать') : CHtml::encode('Сохранить')); ?>
            </div>
    
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>