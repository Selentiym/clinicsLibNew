<div class="row-fluid">
    <?php echo CHtml::beginForm('', 'post', array('id' => 'banners-form', 'enctype'=>'multipart/form-data')); ?>

    <div class="span5">
        <?php if(Yii::app()->user->hasFlash('nothingToUploadTop')): ?>
            <div class="alert-danger">
                <?php echo Yii::app()->user->getFlash('nothingToUploadTop'); ?>
            </div>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->hasFlash('errorUploadTop')): ?>
            <div class="alert-danger">
                <?php echo Yii::app()->user->getFlash('errorUploadTop'); ?>
            </div>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->hasFlash('successfullUploadTop')): ?>
            <div class="alert-success">
                <?php echo Yii::app()->user->getFlash('successfullUploadTop'); ?>
            </div>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->hasFlash('nothingToUploadSide')): ?>
            <div class="alert-danger">
                <?php echo Yii::app()->user->getFlash('nothingToUploadSide'); ?>
            </div>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->hasFlash('errorUploadSide')): ?>
            <div class="alert-danger">
                <?php echo Yii::app()->user->getFlash('errorUploadSide'); ?>
            </div>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->hasFlash('successfullUploadSide')): ?>
            <div class="alert-success">
                <?php echo Yii::app()->user->getFlash('successfullUploadSide'); ?>
            </div>
        <?php endif; ?>        
        
         <div class="row-fluid">
            <?php echo CHtml::label(CHtml::encode('Верхний баннер'), ''); ?>
             <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            <?php echo CHtml::fileField('top_banner',''); ?>
            <?php
                if (trim($top_banner->value) != "") {
                    $top_banner_img = Yii::app()->baseUrl.'/images/banners/' . $top_banner->value;
                    echo '<div id="top_banner">' . CHtml::ajaxLink('<i class="icon-remove"></i>', CController::createUrl('admin/propDelete/'), array('type'=> 'POST', 'data'=>array('prop' => 'top_banner'), 'success' => 'js: $("#top_banner").hide()'))
                     .CHtml::image($top_banner_img, CHtml::encode('Верхний баннер'), array('style' => 'max-width:200px; padding: 8px 0px 8px 15px;', )) . '</div>';
                }
            ?>
        </div>

         <div class="row-fluid">
            <?php echo CHtml::label(CHtml::encode('Боковой баннер'), ''); ?>
             <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            <?php echo CHtml::fileField('side_banner',''); ?>
            <?php
                if (trim($side_banner->value) != "") {
                    $side_banner_img = Yii::app()->baseUrl.'/images/banners/' . $side_banner->value;
                    echo '<div id="side_banner">' . CHtml::ajaxLink('<i class="icon-remove"></i>', CController::createUrl('admin/propDelete/'), array('type'=> 'POST', 'data'=>array('prop' => 'side_banner'), 'success' => 'js: $("#side_banner").hide()'))
                     . CHtml::image($side_banner_img, CHtml::encode('Боковой баннер'), array('style' => 'max-width:200px; padding: 8px 0px 8px 15px;', )) . '</div>';
                }
            ?>
        </div>

        <div class="buttons">
            <?php echo CHtml::submitButton(CHtml::encode('Сохранить')); ?>
        </div>

    </div>
    <?php echo CHtml::endForm(); ?>
</div>