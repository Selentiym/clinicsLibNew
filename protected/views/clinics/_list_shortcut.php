<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2016
 * Time: 17:45
 */
/**
 * @type clinics $model
 */
$logoName = $model -> giveImageFolderRelativeUrl() . $model -> logo;
//if (!file_exists($filename)) {
if (!$model -> logo) {
    //echo $filename;
    $filename = Yii::app() -> baseUrl . '/img/noImage.jpg';
}
?>
<div class="row clinic">
    <div class="col-md-2 col-sm-2">
        <img alt="" src="<?=$logoName?>">
    </div>
    <div class="col-md-10 col-sm-10">
        <h2><a href="<?php echo Yii::app() -> baseUrl.'/clinics/'. $model -> verbiage; ?>"><?=$model->name?></a></h2>
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
                <?php
                    $tel = $model -> phone;
                    if (!$tel) {
                        $tel = ' - ';
                    }
                    $shortTel = preg_replace('/[^\d]/','',$tel);
                ?>
                <?php if ($model -> partner): ?>
                <div class="center-phone"><a href="tel:8812<?php echo CallTrackerModule::getShortNumber(); ?>"><?php echo CallTrackerModule::getFormattedNumber(); ?></a></div>
                <?php else: ?>
                <div class="center-phone"><a href="tel:<?=$shortTel?>"><?=CHtml::ajaxShowButton(Yii::app() -> baseUrl.'/site/viewClinicPhone','Показать телефон',$model -> id, $tel)?></a></div>
                <?
                endif;
                $distr = CHtml::giveStringFromIdString('Districts', $model -> district, 'name');
                ?>
                <div class="center-address"><?=$model->address?><br><span class="center-region"><?=$distr?> район</span></div>
                <div class="center-hours"><?=$model->working_hours?></div>
                <span class="center-region"><?=$model->phone_extra?></span>
                <div class="center-stars">
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
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="center-prices">
                    <?php if ($prMrt = $model -> giveMinMrtPrice()) { echo "<p><b>МРТ</b> от $prMrt->price руб.</p>"; } ?>
                    <?php if ($prMrt = $model -> giveMinKtPrice()) { echo "<p><b>КТ</b> от $prMrt->price руб.</p>"; } ?>
                </div>
                <a class="fancybox to_sign" href="#callback-registration">Записаться</a>
            </div>
        </div>
    </div>
</div>
<div class="line"></div>
