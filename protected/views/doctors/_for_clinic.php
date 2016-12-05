<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.10.2016
 * Time: 7:57
 */
/**
 * @type doctors $model
 */
?>

<div class="col-md-6">
    <div class="doctor">
        <?php if (file_exists($model->giveImageFolderRelativeUrl().$model->logo)): ?>
        <img alt="<?=$model->name?>" src="<?=$model->giveImageFolderRelativeUrl().$model->logo?>">
        <?php endif; ?>
        <h4><?=$model->name?></h4>
        <p><?=$model->description?></p>
	<div class="clear"></div>
	</div>
</div>
