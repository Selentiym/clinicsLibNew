<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2016
 * Time: 22:07
 */
$cityCodes = array(
    'Санкт-Петербург' => 'spb',
    'Воронеж' => 'vrn',
    'Екатеринбург' => 'ekb',
    'Ижевск' => 'izh',
    'Казань' => 'kazan',
    'Краснодар' => 'krd',
    'Московская область' => 'mo',
    'Нижний Новгород' => 'nn',
    'Новосибирск' => 'nsk',
    'Пермь' => 'perm',
    'Ростов-на-Дону' => 'rnd',
    'Самара' => 'samara',
    'Уфа' => 'ufa',
    'Челябинск' => 'chlb'
);
if ($_GET['ip']) {
    $geo = new Geo(array('ip' => $_GET['ip']));
} else {
    $geo = new Geo();
}
$city = $geo -> get_value('city');
$code = $cityCodes[$city];
if (!$code) { $code = 'msc'; }
Yii::app() -> getClientScript() -> registerScriptFile('https://docdoc.ru/widget/js', CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScript('useWidget',"
    DdWidget({
		id: 'DDWidgetDoctorList',
		widget: 'DoctorList',
		template: 'DoctorListVitaPortal_640',
		limit: '15',
		theme: 'DoctorList/theme5',
		pid: '7159',
		container: 'DDWidgetDoctorList',
		action: 'LoadWidget',
		city: '".$code."'
	});
", CClientScript::POS_READY);

?>
<div class="main_content">
    <div class="in_main_content">
        <div class="in_main_content_left article_left ">
            <div id="DDWidgetDoctorList"></div>
        </div>
        <div>
            <?php $this -> renderPartial('//layouts/right_column'); ?>
        </div>
    </div>
</div>
