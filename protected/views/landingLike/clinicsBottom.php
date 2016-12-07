<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.11.2016
 * Time: 17:45
 */
/**
 * @type clinics $model
 */
Yii::app() -> getClientScript() -> registerScript('vkForm','
    sendVkLoginRequest();
',CClientScript::POS_READY);
Yii::app() -> getClientScript() -> registerScript('toggleMoreReviews','
    var page = 0;
    var $moreReviewsCont = $("#showMoreReviews");
    function addMoreReviews() {
        toReplace = $("#showMoreReviews");
        toReplace.html($("<img>",{
            src:baseUrl+"/img/loading.gif",
            css:{height:"20px", width:"20px"}
        }));
        $.post(baseUrl + "/moreReviews",{
            currentPage: page,
            objectInfo:'.json_encode(['id' => $model -> id]).'
        }).done(function(data){
            if ((data)&&(toReplace)) {
                toReplace.replaceWith(data);
                page ++;
            }
        });
    }
    $("body").on("click", "#showMoreReviews", function(){
        addMoreReviews();
    });
    addMoreReviews();
',CClientScript::POS_READY);
?>
<h2>Отзывы посетителей о наших клиниках</h2>

<div class="reviews">
    <div class="wcomments_page _wcomments_page wcomments_section_posts">
        <div class="wcomments_head _wcomments_head clear_fix">
            <a class="wcomments_logo" href="/dev/Comments"></a>
				<span class="wcomments_count _wcomments_count">
					<?php
                    if ($showAll) {
                        $toShow = Comments::model() -> findAllByAttributes(['approved' => 1],['order' => 'num ASC']);
                    } else {
                        $toShow = $model->approved_comments;
                    }
                    $total = count($toShow);
                    $word = 'комментари';
                    $num = $total%10;
                    if (($num == 0)||($num >= 5)||(($num >= 10)&&($num <= 20))) {
                        $word .= 'ев';
                    } elseif ($num == 1) {
                        $word .= 'й';
                    } elseif (($num >= 2) && ($num <= 4)) {
                        $word .= 'я';
                    }
                    echo $total.' '.$word;
                    ?> </span>
        </div>

        <div class="_wcomments_content wcomments_content">
            <div class="_wcomments_form clear_fix">
                <div class="wcomments_form" style="display:none">
                    <div id="submit_post_error" class="box_error wcomments_post_error"></div>
                    <a href="http://vk.com" id="vk_avatar_link" class="wcomments_form_avatar"><img id="vk_avatar_round_small" src="http://vk.com/images/camera_50.png"></a>
                    <div id="submit_post_box" class="wcomments_post_box shown clear_fix">
                        <div class="_emoji_field_wrap">
                            <div id="post_field" class="wcomments_post_field dark submit_post_inited" contenteditable="true"></div>
                            <div class="placeholder"><div class="ph_input"><div class="ph_content">Ваш комментарий...</div></div></div></div>
                        <div id="submit_post" class="wcomments_submit_post clear_fix">
                            <div id="media_preview" class="clear_fix media_preview"></div>
                            <div class="addpost_button_wrap" id="reply_box_main">
                                <button class="flat_button addpost_button" id="send_post">Отправить</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="wcomments_form" style="text-align:center">
                    <button class="flat_button" id="show_input">Оставить свой отзыв</button>
                </div>
            </div>

            <div class="_wcomments_posts_outer wcomments_posts_outer no_post_click wall_module wide_wall_module">
                <div class="wcomments_posts_inner">
                    <div id="wcomments_posts" class="wcomments_posts">

                        <?php
                        //$this -> renderPartial('//landingLike/commentsPage',['page' => 0]);
                        ?>
                        <div id='showMoreReviews'>Показать еще</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'comment-form',
    'action'=> Yii::app()->baseUrl.'/clinics/comment',
));
/**
 * @type CActiveForm $form
 */
$comment = new Comments();
$comment -> user_first_name = 'vk';
echo $form -> hiddenField($comment, 'user_first_name');
echo $form -> hiddenField($comment, 'text', ['id' => 'ReviewTextHidden']);
echo $form -> hiddenField($comment, 'vk_id', ['id' => 'VkIdHidden']);
echo $form -> hiddenField($comment, 'noPersonalPage', ['name' => 'noPersonalPage', 'value' => 1]);
echo CHtml::hiddenField('object_id', $model -> id);


$this->endWidget();

?>