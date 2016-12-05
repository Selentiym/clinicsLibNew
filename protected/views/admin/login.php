    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions' => array(
                'class' => 'well',
                'style' => 'text-align: center'
            )
        )); ?>

            <p><?php echo CHtml::encode('Пожалуйста, введите логин и пароль администратора'); ?></p>

            <div class="row-fluid">
                <?php echo $form->labelEx($model,'username'); ?>
                <?php echo $form->textField($model, 'username'); ?>
                <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="row-fluid">
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password'); ?>
                <?php echo $form->error($model,'password'); ?>
            </div>

            <div class="row-fluid buttons">
                <?php echo CHtml::submitButton(CHtml::encode('Войти'), array('class' => 'btn btn-info')); ?>
            </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->