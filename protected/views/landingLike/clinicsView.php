<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.11.2016
 * Time: 17:41
 */
/**
 * @type clinics $model
 */
	$base = Yii::app() -> baseUrl;
	/**
     * @type clinics $model
     */
	Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/map.js');
	Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/widget_comments.css');
	Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/vk_lite.css');
	Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/vk_page.css');
	Yii::app()->getClientScript()->registerScript("send_request","
	sendVkLoginRequest();
	",CClientScript::POS_READY);
?>
<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
<script type="text/javascript">
    VK.init({
        apiId: 5711487
    });
    var logged;
    VK.Auth.getLoginStatus(function(data){
        console.log(data);
    });
</script>

    <div class="clinic-h1"><img alt="<?php echo $model -> name; ?>" src="<?php echo $model->giveImageFolderRelativeUrl().$model->logo; ?>"><h1><?php echo $model -> name; ?></h1></div>
    <div class="clear"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="center-mrtkt">
                <b>МРТ и КТ</b>
                <table><tbody>
                    <tr><td>Модель МРТ: </td><td><a href="#"><?=$model->mrt?></a></td></tr>
                    <tr><td>Модель КТ: </td><td><a href="#"><?=$model->kt?></a></td></tr>
                </tbody></table>
            </div>

            <?php
            $tel = $model -> phone;
            $shortTel = preg_replace('/[^\d]/','',$tel);
            if (!$tel) {
                $tel = ' - ';
            }
            ?>
            <?php if ($model -> partner): ?>
                <div class="center-phone"><a href="tel:8812<?php echo CallTrackerModule::getShortNumber(); ?>"><?php echo CallTrackerModule::getFormattedNumber(); ?></a></div>
            <?php else: ?>
                <div class="center-phone"><a href="tel:<?=$shortTel?>"><? CHtml::ajaxShowButton(Yii::app() -> baseUrl.'/site/viewClinicPhone','Показать телефон',$model -> id, $tel); ?></a></div>
            <?php
                endif;
                $distr = CHtml::giveStringFromIdString('Districts', $model -> district, 'name');
            ?>
            <div class="center-address"><?php echo $model->address; ?><br><a href="#"><?php echo $distr; ?> район</a></div>
            <div class="center-hours"><?php echo $model->working_hours; ?></div>
        </div>
        <div class="col-md-6">
            <div class="center-stars">
                <p>Рейтинг по отзывам посетителей:</p>
                <?php
                $i = 0;
                while($i < 5){
                    if ($i <= $model -> rating) {
                        $color = "red";
                    } else {
                        $color = "grey";
                    }
                    echo "<div class='$color-star'></div>";
                    $i++;
                }
                ?>
                <a class="fancybox to_sign" href="#callback-registration">Записаться</a>
            </div>
        </div>
    </div>
</div>
