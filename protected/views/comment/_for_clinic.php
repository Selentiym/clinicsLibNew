<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.10.2016
 * Time: 19:58
 */
/**
 * @type Comments $model
 */
?>
<div class="review-outer">
    <div class="review-inner">
        <div class="review-author">
            <?= $model->user_first_name ?>
        </div>
        <div class="review-text">
            <?=$model->text?>
        </div>
    </div>
</div>
