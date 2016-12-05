<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.10.2016
 * Time: 22:03
 */
?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/map_select.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/map_select.css'); ?>
<?php $base = Yii::app() -> baseUrl; ?>



<div id="content" class="main_page">
    <div>
        <h2>ДИАГНОСТИЧЕСКИЕ ЦЕНТРЫ ВО ВСЕХ РАЙОНАХ САНКТ-ПЕТЕРБУРГА</h2>
        <div class="line" style="margin-bottom:0;"></div>


        Ниже на карте, представленны все диагностические медицинские центры Санкт-Петербурга. Для получения более подробной информации по заинтересовавшей вас клинике, достаточно кликнуть на соответствующую ей метку на карте.
        <div class="line" style="margin-bottom:0;"></div>

    </div>
    <?php
    Yii::app()->getClientScript()->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
    $toAdd = '';
    $criteria = new CDbCriteria();
    $criteria -> compare('ignore_clinic', 0);
    $clinics_to_map = clinics::model() -> findAll($criteria);
    //$clinics_to_map = clinics::model() -> findAllByAttributes(['partner' => 1]);
    foreach ($clinics_to_map as $clinic) {
        if ($clinic -> map_coordinates) {
            $temp = [
                "hintContent" => $clinic -> name.', '.$clinic->address
            ];
            $toAdd .= "{$clinic -> verbiage} = new ymaps.Placemark( [{$clinic -> map_coordinates}] , ".json_encode($temp).");";
            $toAdd .= $clinic -> verbiage.".events.add('click', function(e) {
                loadClinicInfo($clinic->id);
            });";
            $toAdd .= "window.allClinicsMap.geoObjects.add({$clinic -> verbiage});";
        }
    }
    Yii::app()->getClientScript()->registerScript("map_init","
    ymaps.ready(function () {
    window.allClinicsMap = new ymaps.Map('bigMap', {
    center: [59.939095, 30.315868],
    zoom: 10
    }, {
    searchControlProvider: 'yandex#search'
    });
    ".$toAdd."

    });
    ",CClientScript::POS_READY);
    ?>
    <div id="bigMap">

    </div>
    <!--<div id="main-map">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=fHrbBwPUg74-JUPpCs4bVzOeggNwiwgJ&amp;width=100%&amp;height=100%&amp;lang=ru_RU&amp;sourceType=constructor&amp;"></script>
    </div>-->
    <div class="clear"></div>
    <div class="line"></div>
    <div id="toShowClinicInfo">

    </div>