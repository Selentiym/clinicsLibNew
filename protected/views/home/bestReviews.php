<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.10.2016
 * Time: 21:18
 */
?>
<div id="content" class="main_page">
    <div id="main-text">
        <div class="line" style="margin-bottom:0;"></div>
        <h2>РЕЙТИНГ КЛИНИК ПО ОТЗЫВАМ ПАЦИЕНТОВ</h2>
        <p>Ниже представлены клиники с наиболее высоким рейтингом, основанным на отзывах пациентов и мнении лечащих врачей клиницистов. Для того, чтобы ознакомиться с соответствующими отзывами, достаточно кликнуть на интересующую Вас клинику.</p>
    </div>
    <?php
    Yii::app()->getClientScript()->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
    $toAdd = '';
    $clinics_to_map = clinics::model() -> findAll();
    //$clinics_to_map = clinics::model() -> findAllByAttributes(['partner' => 1]);
    foreach ($clinics_to_map as $clinic) {
        if ($clinic -> map_coordinates) {
            $temp = [
                "hintContent" => $clinic -> name.', '.$clinic->address
            ];
            $toAdd .= "{$clinic -> verbiage} = new ymaps.Placemark( [{$clinic -> map_coordinates}] , ".json_encode($temp).");";
            $toAdd .= "window.allClinicsMap.geoObjects.add({$clinic -> verbiage});";
        }
    }
    Yii::app()->getClientScript()->registerScript("map_init","
    ymaps.ready(function () {
    window.allClinicsMap = new ymaps.Map('main-map', {
    center: [59.939095, 30.315868],
    zoom: 10
    }, {
    searchControlProvider: 'yandex#search'
    });
    ".$toAdd."
    });
    ",CClientScript::POS_READY);
    ?>
    <div id="main-map">

    </div>

<div id="catalog-jump" class="clear"></div>

    <?php
        $criteria = new CDbCriteria();
        $criteria -> order = 'rating DESC';
        $criteria -> compare('partner', 1);
        $criteria -> compare('ignore_clinic', 0);
        $objects = clinics::model() -> findAll($criteria);
        if (!empty($objects)) {
            foreach ($objects as $obj) {
                $this->renderPartial("//clinics/_list_shortcut", ['model' => $obj]);
            }
        } else {
            echo "<div style='margin:0 auto'>";
            echo "<p>По Вашим критериям ничего не найдено.</p>";
            echo '
            <div class="search-reset-buttons">
				<a class="reset-button" href="'.$base.'/?clear=1">Сбросить</a>
			</div>
			';
            echo "</div>";
        }
    ?>
</div>