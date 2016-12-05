<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.11.2016
 * Time: 21:14
 */
//31 окт в 21:40
/**
 * @type Comments $model
 */
$vk = $model -> getVkAccount();
?>
<div class="_post post wcomments_post">
    <div class="_post_content">
        <a target="_blank" class="post_image" href="<?php echo $vk -> genUrl(); ?>">
            <img src="<?php echo $vk -> photo; ?>" class="post_img">
        </a>
        <div class="post_content">
            <div class="wcomments_post_content">
                <div class="post_author"><a target="_blank" class="author" href="<?php echo $vk -> genUrl(); ?>" data-from-id="334550061" data-post-id="334550061_89"><?php echo $vk -> first_name.' '.$vk -> last_name; ?></a> <span class="explain"><span class="wall_fixed_label">&nbsp;запись закреплена</span></span></div>
                <div class="post_info">
                    <div class="wall_text">
                        <div class="_wall_post_cont">
                            <div class="wall_post_text">
                                <?=$model->text?>
                            </div>
                        </div>
                    </div>
                    <div class="wcomments_post_footer clear_fix">
                        <div class="post_date"><span class="rel_date"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>