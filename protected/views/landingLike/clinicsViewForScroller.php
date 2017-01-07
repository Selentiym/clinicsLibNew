<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.12.2016
 * Time: 19:44
 */
?>
<div id="<?php echo "clinicsScroll".$model -> id; ?>">
<div class="clinic-h1"><img alt="<?php echo $model -> name; ?>" src="<?php echo $model->giveImageFolderRelativeUrl().$model->logo; ?>"><h1><?php echo $model -> name; ?></h1></div>
<div class="row">
    <div class="col-md-12">
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
    <div class="col-md-12">
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
            <a class="fancybox to_sign formable" href="#callback-registration">Записаться</a>
        </div>
    </div>
</div>
</div>