<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2016
 * Time: 15:37
 */

$base = Yii::app() -> baseUrl;

$clinics_to_map = $this -> giveClinics();

$utm = $_REQUEST['utm_term'];
$selectedClinic = ClinicRule::selectClinic($utm);

Yii::app() -> getClientScript() -> registerScript('defineBase','
    baseUrl="'.$base.'";
',CClientScript::POS_BEGIN);
Yii::app() -> getClientScript() -> registerScriptFile($base.'/jsLandingLike/jquery-1.11.1.min.js',CClientScript::POS_BEGIN);
Yii::app() -> getClientScript() -> registerScriptFile($base."/jsLandingLike/jquery.maskedinput.min.js",CClientScript::POS_END);
//Yii::app() -> getClientScript() -> registerScriptFile($base."/fancybox/jquery.fancybox.pack.js",CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScriptFile($base."/jsLandingLike/common.js",CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScriptFile($base."/jsLandingLike/flipclock.js",CClientScript::POS_END);
//header scroll scripts
Yii::app() -> getClientScript() -> registerScriptFile($base."/jsLandingLike/script.js",CClientScript::POS_END);

Yii::app() -> getClientScript() -> registerScriptFile($base."/jsLandingLike/bigMapClinicSelect.js",CClientScript::POS_END);

//doctors slider
Yii::app() -> getClientScript() -> registerScriptFile($base."/libsLandingLike/owl-carousel/owl.carousel.min.js",CClientScript::POS_END);


Yii::app() -> getClientScript() -> registerCssFile($base."/libsLandingLike/owl-carousel/owl.carousel.css");

Yii::app() -> getClientScript() -> registerScriptFile("http://vk.com/js/api/openapi.js",CClientScript::POS_BEGIN);


//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/map.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/widget_comments.css');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/vk_lite.css');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/vk_page.css');

//smoothClinicsCarousel
Yii::app() -> getClientScript() -> registerPackage('smoothDivScroll');
Yii::app() -> getClientScript() -> registerPackage('simplePopup');
Yii::app() -> ClientScript -> registerScript('countDown',"
var clock;
clock = $('#clock').FlipClock({
    clockFace: 'DailyCounter',
    autoStart: false,
    defaultLanguage: 'rus',
    callbacks: {
        stop: function() {
            $('.message').html('Время вышло!')
        }
    }
});
var toTime = new Date();
var toAdd = toTime.getDate() % 3 + 2;
toTime.setMinutes(0);
toTime.setSeconds(0);
toTime.setHours(toAdd*24);
var nowTime = new Date();
clock.setTime(Math.floor((toTime - nowTime)/1000));
clock.setCountdown(true);
clock.start();
",CClientScript::POS_READY);

Yii::app() -> getClientScript() -> registerScriptFile(Yii::app() -> baseUrl.'/js/clinicsCarousel.js', CClientScript::POS_BEGIN);

Yii::app() -> getClientScript() -> registerScript('clinicsCarousel',"
startClinicsCarousel(window, '".($selectedClinic instanceof clinics ? $selectedClinic -> id : '')."');
",CClientScript::POS_READY);

Yii::app() -> getClientScript() -> registerScript('bigScriptOnLoad','
$(".your-phone").mask("+7(999)999-99-99");
', CClientScript::POS_READY);

Yii::app() -> getClientScript() -> registerScript('loadVkApi','
VK.init({
    apiId: 5711487
});
var logged;
VK.Auth.getLoginStatus(function(data){
    console.log(data);
});
', CClientScript::POS_READY);

Yii::app() -> getClientScript() -> registerScript('sendForms','
$("form").not(".ordinary").submit(function(e){
    var toSubmit = $(this).find("[type=\'submit\']");
    toSubmit.attr("disabled",true);
    toSubmit.addClass("loading");
    var toAlert = true;
    setTimeout(function () {
        if (toAlert) {
            toSubmit.attr("disabled",false);
            toSubmit.removeClass("loading");
            alert("По какой-то причине ответ от сервера не пришел. Проверьте интернет-соединение и попробуйте еще раз, пожалуйста.");
        }
    }, 30000);

    $.post(baseUrl+"/post",$(this).serialize()).done(function(date){
            alert("Ваша заявка успешно принята!");
            price = callTrackerJS.price;
            if (!price) {
                price = 250;
            }
            if (yaCounter40204894) {
                yaCounter40204894.reachGoal("formSubmit", {
                    order_price: price,
                    currency: "RUB"
                });
            } else {
                $.post(baseUrl+"/home/couldNotReachGoal",{type:"form"});
            }
        }).fail(function(){
            alert("Возникла ошибка при отправке. Пожалуйста, попробуйте еще раз или воспользуйтесь одним из указанных телефонных номеров.");
        }).always(function () {
            toAlert = false;
            toSubmit.attr("disabled",false);
            toSubmit.removeClass("loading");
        });

    return false;
});
', CClientScript::POS_READY);

Yii::app() -> getClientScript() -> registerScript('defaultPositions','
    //Действия по умолчанию
    $(".tab_content").hide(); //скрыть весь контент
    $("ul.tabs li:first").addClass("active").show(); //Активировать первую вкладку
    $(".tab_content:first").show(); //Показать контент первой вкладки

    //Событие по клику
    $("ul.tabs li").click(function() {
        $("ul.tabs li").removeClass("active"); //Удалить "active" класс
        $(this).addClass("active"); //Добавить "active" для выбранной вкладки
        $(".tab_content").hide(); //Скрыть контент вкладки
        var activeTab = $(this).find("a").attr("href"); //Найти значение атрибута, чтобы определить активный таб + контент
        $(activeTab).fadeIn(); //Исчезновение активного контента
        return false;
    });
', CClientScript::POS_READY);

    $toAdd = '';
    Yii::app()->getClientScript()->registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU", CClientScript::POS_BEGIN);
    foreach ($clinics_to_map as $clinic) {
        if ($clinic -> map_coordinates) {
            $temp = [
                "hintContent" => $clinic -> name.', '.$clinic->address
            ];
            $toAdd .= "{$clinic -> verbiage} = new ymaps.Placemark( [{$clinic -> map_coordinates}] , ".json_encode($temp).");";
            $toAdd .= $clinic -> verbiage.".events.add('click', function(e) {
                                                    onClinicSelected($clinic->id);
                                                });";
            $toAdd .= "window.allClinicsMap.geoObjects.add({$clinic -> verbiage});";
        }
    }
    Yii::app()->getClientScript()->registerScript("map_init2","
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

<!DOCTYPE html>
<html lang="ru" data-form-func="textPopup">
<head>
    <meta charset="utf-8" />
    <title>Самая крупная сеть МРТ и КТ диагностических центров в СПб</title>
    <meta name="description" content="Каталог клиник МРТ и КТ" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width; initial-scale=0.85; maximum-scale=0.85; user-scalable=0;" />
    <link rel="shortcut icon" href="<?php echo $base; ?>/img/favicon.png" />
    <link rel="stylesheet" href="<?php echo $base; ?>/cssLandingLike/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/cssLandingLike/font-awesome.min.css" />
    <!--<link rel="stylesheet" href="<?php echo $base; ?>/fancybox/jquery.fancybox.css" />-->
    <link rel="stylesheet" href="<?php echo $base; ?>/cssLandingLike/main.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/cssLandingLike/flipclock.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/cssLandingLike/media.css" />
</head>
<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                var yaParams = <?php $params = CallTrackerModule::getExperiment() -> getParams(); $params['design'] = 'desktop'; echo json_encode($params); ?>;
                w.yaCounter40204894 = new Ya.Metrika({
                    id:40204894,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    params: yaParams || {}
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40204894" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<header class="header_topline">

    <div class="container ">
        <div class="row">
            <div class="col-md-4 col-xs-9">
                <a class="logo" href="#">
                    <img alt="" src="<?php echo $base; ?>/imgLandingLike/logo.png">
                    <span>Самая крупная сеть <span>МРТ</span> и <span>КТ</span><br /> диагностических центров в СПб</span>
                </a>
            </div>
            <nav class="col-md-8 col-xs-3 main_menu clearfix">
                <button class="main_mnu_button hidden-md hidden-lg"><i class="fa fa-bars"></i></button>
                <ul>
                    <li class="discount-sale top-phone formable"><a class="fancybox" href="#callback-registration" target="_blank"><img alt="Записаться" src="<?php echo $base; ?>/imgLandingLike/top-phone.png">Запись <br /> на МРТ и КТ
                            <span class="menu-desc">24 часа!</span>
                        </a>
                    </li>
                    <li class="discount-sale"><a href="#hot-offers"><span class="menu-title"><i class="fa fa-percent" aria-hidden="true"></i><img alt="" src="<?php echo $base; ?>/imgLandingLike/percent.png">Самые горячие<br /> предложения по СПб</span><span class="menu-desc">Скидки и Акции</span></a></li>
                    <li class="our-centers"><a href="#centers"><span class="menu-title">Наши <br />Центры</span></a></li>
                    <li class="our-prices"><a href="#prices"><span class="menu-title">Наши<br /> Цены</span></a></li>
                    <li class="our-phone"><a href="#callback-registration" id="form-button" class="order fancybox"><span class="menu-title"><?php echo CallTrackerModule::getFormattedNumber();?></span>
                            <img src="<?php echo $base; ?>/imgLandingLike/phone-sm.png" alt="" /><span class="menu-desc formable">Заказать обратный звонок</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <aside class="col-md-4 ">
            <div class="aside-block">
                <h2>Центры на карте</h2>
                <div id="main-map">

                </div>
                <div><a class=" to_sign" href="#mapLink">Перейти к большой карте»</a></div>

                <div class="line"></div>

                <!--Записаться на МРТ и КТ-->
                <h2>Записаться на МРТ и КТ</h2>
                <div class="left-images-block coll-box">
                    <div class="order-form">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12"><input type="text" class="your-name" name="name" placeholder="Ваше имя.." pattern=".+" required=""></div>
                                <div class="col-md-12"><input type="text" class="your-phone"  name="phone" placeholder="Ваш телефон.." pattern="[0-9-+()\s]{8,20}$" required=""></div>
                                <div class="col-md-12"><input type="submit" name="submit" value="Оставить заявку" class="submit"></div>
                            </div>
                        </form>
                    </div>
                    <p class="left-images-block-header"> Многоканальный телефон для записи на МРТ или КТ исследование: </p>
                    <p style="text-indent: 10%"><a class="callcenter-phone" href="tel:8812<?=CallTrackerModule::getShortNumber();?>"><?php echo CallTrackerModule::getFormattedNumber();?></a></p>
                    <ul class="red-label">
                        <li>Специалист-диагност подберет Вам <b>подходящую клинику</b> и <b>наилучшую цену</b>, а также запишет на обследование в удобное для Вас время.</li>
                        <li>Ответит на все вопросы, связанные с МРТ и КТ диагностикой.</li>
                    </ul>
                </div>

                <!--Баннер оборудование-->
                <div class="banner" id="oborud">
                    <h2>ОБОРУДОВАНИЕ</h2>
                    <!--Баннер 1-->
                    <div class="left-images-block formable" data-form-text="<p>Аппарат 3 Тесла позволяет получить значительно более четкую картину, чем стандартный 1,5 Тесла, но немногие клиники им оснащены.</p> <p>У нас Вы сможете получить высокое качество по доступной цене.</p> <p>Наш специалист-диагност перезвонит Вам в течение 5 минут. Он может и с радостью ответит на все интересующие Вас вопросы.</p>">
                        <a href="#">
                            <div>
                                <p>
                                    <span>МРТ на Аппарате 3 Тесла</span><br />
                                    <span class="banner-big-font">по самой низкой</span><br />
                                    <span class="banner-big-font banner-blue-font">цене в городе</span>
                                </p>
                            </div>
                        </a>
                    </div>

                    <!--Баннер 2-->
                    <div class="left-images-block formable" data-form-text="<p>Аппарат полуоткрытого типа - золотая середина между мощными аппаратами закрытого типа и комфортными аппаратами открытого типа. Вы получаете качественный результат с повышенным комфортом.</p><p>Если Вы хотите поподробнее узнать про механизм проведения исследований, заполните форму, и наш специалист-консультант свяжется с Вами в течение 5 минут! Он даст ответ на любые Ваши вопросы.</p><p>Консультация абсолютно бесплатна, и мы всегда рады Вас слышать.</p>">
                        <a href="#">
                            <div>
                                <p><span>МРТ томографы 1.5 Тл, полуоткрытого типа -</span><br />
                                    <span class="banner-big-font">оборудование </span><span class="banner-big-font banner-blue-font">экспертного класса!&nbsp;</span></p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                            </div>
                        </a>
                    </div>

                    <!--Баннер 3-->
                    <div class="left-images-block formable" data-form-text="<p>У нас Вы можете пройти обследование на аппарате открытого типа, позволяющем получить тот же самый результат, что и на обычном томографе.</p><p>Если Вы хотите поподробнее узнать про механизм проведения исследований, заполните форму, и наш специалист-консультант свяжется с Вами в течение 5 минут! Он даст ответ на любые Ваши вопросы.</p><p>Консультация абсолютно бесплатна, и мы всегда рады Вас слышать.</p>">
                        <a href="#">
                            <div>
                                <p><span>МРТ аппарат открытого типа -</span>
                                    <span class="banner-blue-font">прием ведет Профессор кафедры лучевой диагностики,</span><br />
                                    <span class="banner-big-font">доктор медицинских наук.&nbsp;</span></p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                            </div>
                        </a>
                    </div>

                    <!--Баннер 4-->
                    <div class="left-images-block formable" data-form-text="<p>128-срезовый и 64-срезовый аппараты - лучший выбор для исследования сердца и сосудов: высочайшее разрешение и минимальная доза по доступной цене.</p><p>Более подробную информацию Вы можете получить у нашего специалиста-диагноста, заполнив форму ниже. Вам перезвонят в течение пяти минут.</p>">
                        <a href="#">
                            <div>
                                <p><span>128 срезовый компьютерный томограф – </span>
                                    <span class="banner-big-font banner-blue-font">лучший аппарат в городе!</span><br /><br />
                                    <span>Также парк оборудования нашей сети клиник</span>
                                    <span class="banner-big-font banner-blue-font">оснащен</span>
                                    <span>16-ти и 64-х срезовыми компьютерными томографами.&nbsp;</span></p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                            </div>
                        </a>
                    </div>
                    <!--/Баннер 4-->
                </div>
                <div id="bottomAssignAnchor"></div>
                <!--Записаться еще раз -->
                <div class="left-images-block coll-box" id="assignBottom">
                    <div class="order-form">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12"><input type="text" class="your-name" name="name" placeholder="Ваше имя.." pattern=".+" required=""></div>
                                <div class="col-md-12"><input type="text" class="your-phone"  name="phone" placeholder="Ваш телефон.." pattern="[0-9-+()\s]{8,20}$" required=""></div>
                                <div class="col-md-12"><input type="submit" name="submit" value="Оставить заявку" class="submit"></div>
                            </div>
                        </form>
                    </div>
                    <p class="left-images-block-header"> Многоканальный телефон для записи на МРТ или КТ исследование: </p>
                    <p style="text-indent: 10%"><a class="callcenter-phone" href="tel:8812<?=CallTrackerModule::getShortNumber();?>"><?php echo CallTrackerModule::getFormattedNumber();?></a></p>
                    <ul class="red-label">
                        <li>Специалист-диагност подберет Вам <b>подходящую клинику</b> и <b>наилучшую цену</b>, а также запишет на обследование в удобное для Вас время.</li>
                        <li>Ответит на все вопросы, связанные с МРТ и КТ диагностикой.</li>
                    </ul>
                </div>
            </div>
        </aside>

        <!--Правая сторона-->
        <div class="col-md-8">
            <div id="content" class="clinic-page">
                <div class="line"></div>
                <div class="row advantages">
                    <div class="col-md-3 formable" data-form-text="<p>Результат в течение суток. Подберем удобную Вам клинику, которая готова провести обследование уже сегодня!</p><p>Наш специалист-диагност позвонит Вам в течение 5 минут. Он готов как сразу записать Вас на подходящую Вам процедуру, так и ответить на все интересующие Вас вопросы.</p>">
                        <img src="<?php echo $base; ?>/imgLandingLike/advantage1.png" alt="" />
                        <span>МРТ и КТ<br /> срочно</span>
                    </div>
                    <div class="col-md-3 formable" data-form-func="nightTextPopup">
                        <img src="<?php echo $base; ?>/imgLandingLike/advantage2.png" alt="" />
                        <span>мрт и кт ночью<br /> скидка 50%</span>
                    </div>
                    <div class="col-md-3 formable" data-form-text="<p>Вам не придется возвращаться за результатом обследования - достаточно немного задержаться после прохождения процедуры: выпить кофе или обсудить свои вопросы с высококвалифицированным специалистом - уже через час Вы получите результаты обследования на руки.</p><p>Наш консультант перезвонит Вам в течение пяти минут, чтобы подобрать самое выгодное для Вас предложение, а также чтобы ответить на все возникшие у Вас вопросы.</p>">
                        <img src="<?php echo $base; ?>/imgLandingLike/advantage3.png" alt="" />
                        <span>Результат<br /> за час</span>
                    </div>
                    <div class="col-md-3 formable" data-form-func="consultTextPopup">
                        <img src="<?php echo $base; ?>/imgLandingLike/advantage5.png" alt="" />
							<span>бесплатная консультация<br /> невролога и травмотолога</span>
                    </div>
                </div>

                <div class="line"></div>

                <?php
                    $this -> renderPartial('//landingLike/prices', ['base' => $base]);
                ?>

                <!--Счетчик-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="discount sale">
                            <h2 class="discount-title">Скидка ночью 50%</h2>
                            <p>на МРТ или КТ исследование</p>
                            <p>до конца акции осталось:</p>
                            <div class="container_countdown">
                                <div id="clock" class="flip-clock-wrapper"><span class="flip-clock-divider days"><span class="flip-clock-label">Days</span></span><ul class="flip "><li class="flip-clock-before"><a href="<?php echo $base; ?>/<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">9</div></div><div class="down"><div class="shadow"></div><div class="inn">9</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">0</div></div><div class="down"><div class="shadow"></div><div class="inn">0</div></div></a></li></ul><ul class="flip "><li class="flip-clock-before"><a href="<?php echo $base; ?>/<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">0</div></div><div class="down"><div class="shadow"></div><div class="inn">0</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li></ul><span class="flip-clock-divider hours"><span class="flip-clock-label">Hours</span><span class="flip-clock-dot top"></span><span class="flip-clock-dot bottom"></span></span><ul class="flip "><li class="flip-clock-before"><a href="<?php echo $base; ?>/<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">0</div></div><div class="down"><div class="shadow"></div><div class="inn">0</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">1</div></div><div class="down"><div class="shadow"></div><div class="inn">1</div></div></a></li></ul><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">1</div></div><div class="down"><div class="shadow"></div><div class="inn">1</div></div></a></li></ul><span class="flip-clock-divider minutes"><span class="flip-clock-label">Minutes</span><span class="flip-clock-dot top"></span><span class="flip-clock-dot bottom"></span></span><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">3</div></div><div class="down"><div class="shadow"></div><div class="inn">3</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li></ul><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">6</div></div><div class="down"><div class="shadow"></div><div class="inn">6</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">5</div></div><div class="down"><div class="shadow"></div><div class="inn">5</div></div></a></li></ul><span class="flip-clock-divider seconds"><span class="flip-clock-label">Seconds</span><span class="flip-clock-dot top"></span><span class="flip-clock-dot bottom"></span></span><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">4</div></div><div class="down"><div class="shadow"></div><div class="inn">4</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">3</div></div><div class="down"><div class="shadow"></div><div class="inn">3</div></div></a></li></ul><ul class="flip  play"><li class="flip-clock-before"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">3</div></div><div class="down"><div class="shadow"></div><div class="inn">3</div></div></a></li><li class="flip-clock-active"><a href="<?php echo $base; ?>/http://mrt-to-go.ru/#"><div class="up"><div class="shadow"></div><div class="inn">2</div></div><div class="down"><div class="shadow"></div><div class="inn">2</div></div></a></li></ul></div>
                            </div>
                        </div>
                        <div class="promocode">
                            <div class="order-form">
                                <form method="post" action="mail.php">
                                    <div class="row">
                                        <div class="col-md-4"><input type="text" class="your-name" name="name" placeholder="Ваше имя.." pattern=".+" required=""></div>
                                        <div class="col-md-4"><input type="text" class="your-phone"  name="phone" placeholder="Ваш телефон.." pattern="[0-9-+()\s]{8,20}$" required=""></div>
                                        <div class="col-md-4"><input type="submit" name="submit" value="записаться" class="submit"></div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="call-us">
                            <p>Для получения скидки и записи на прием к специалисту
                                необходимо оставить заявку или позвонить по тел: </p>
                            <h2 style="text-align:center; margin-top:20px"><a class="callcenter-phone" href="tel:8812<?=CallTrackerModule::getShortNumber();?>"><?php echo CallTrackerModule::getFormattedNumber();?></a></h2>
                        </div>

                        <div class="line" id="nevr"></div>

                        <!--горячие предложения-->
                        <section id="hot-offers">
                            <div class="discount-offers">
                                <h2>Самые горячие предложения по СПБ</h2>
								<div class="discount-inner">
                                    <div class="row" id="travm">
                                        <div id="real-nevr" class="discount-name col-md-5 col-sm-4 col-xs-12">Консультация НЕВРОЛОГА</div>
                                        <div class="discount-price col-md-4 col-sm-4 col-xs-6">
                                            <span class="new-price">БЕСПЛАТНО</span>
                                        </div>
                                        <div class="discount-button col-md-3 col-sm-4 col-xs-6"><a class="fancybox to_sign formable" data-form-func="consultTextPopup" href="#callback-registration">Записаться</a></div>
                                    </div>
                                    <div class="discount-text">
                                        <p>Вы можете посетить бесплатную консультацию невролога до МРТ или КТ исследования, чтобы<br/> уточнить какое обследование
                                                вам нужно, и после — чтобы получить точный диагноз</p>
                                    </div>
                                    <a class="more-about-discount">Подробнее</a>
                                </div>
								<div class="discount-inner">
                                    <div class="row">
                                        <div id="real-travm" class="discount-name col-md-5 col-sm-4 col-xs-12">Консультация ТРАВМАТОЛОГА</div>
                                        <div class="discount-price col-md-4 col-sm-4 col-xs-6">
                                            <span class="new-price">БЕСПЛАТНО</span>
                                        </div>
                                        <div class="discount-button col-md-3 col-sm-4 col-xs-6"><a class="fancybox to_sign formable" data-form-func="consultTextPopup" href="#callback-registration">Записаться</a></div>
                                    </div>
                                    <div class="discount-text">
                                        <p>Вы можете посетить бесплатную консультацию травматолога до МРТ или КТ исследования, чтобы<br/> уточнить какое обследование
                                                вам нужно, и после — чтобы получить точный диагноз</p>
                                    </div>
                                    <a class="more-about-discount">Подробнее</a>
                                </div>

                                <div class="discount-inner">
                                    <div class="row">
                                        <div class="discount-name col-md-5 col-sm-4 col-xs-12">Консультация ДИАГНОСТА</div>
                                        <div class="discount-price col-md-4 col-sm-4 col-xs-6">
                                            <span class="new-price">БЕСПЛАТНО</span>
                                        </div>
                                        <div class="discount-button col-md-3 col-sm-4 col-xs-6"><a class="fancybox to_sign formable" data-form-func="consultTextPopup" href="#callback-registration">Записаться</a></div>
                                    </div>
                                    <div class="discount-text">
                                        <p>При прохождении МРТ и/или КТ обследования в наших клиниках, <br/>консультация врача-диагноста до и после исследования - бесплатна.</p>
                                    </div>
                                    <a class="more-about-discount">Подробнее</a>
                                </div>

								<div class="discount-inner last">
                                    <div class="row">
                                        <div class="discount-name col-md-5 col-sm-4 col-xs-12">МРТ и КТ ночью</div>
                                        <div class="discount-price col-md-4 col-sm-4 col-xs-6" >
                                            <span class="new-price" id="centru">скидка 50%</span>
                                        </div>
                                        <div class="discount-button col-md-3 col-sm-4 col-xs-6"><a class="fancybox to_sign formable" data-form-func="nightTextPopup" href="#callback-registration">Записаться</a></div>
                                    </div>
                                    <span class="anchorContM">
                                        <span id="mapLink" class="anchorM"></span>
                                    </span>
                                    <div class="discount-text">
                                        <p>Хотите сделать МРТ или КТ по самой лучшей цене в СПб?</p>
                                        <p>Ночью действуют скидки на все виды МРТ и КТ обследований!</p>
                                    </div>
                                    <a class="more-about-discount">Подробнее</a>
                                </div>
                            </div>

                        </section>
                        <!--/the best price-->
                        <div class="clear"></div>
                        <div class="line"></div>

                        <!--Наши центры-->
                        <section id="centers">
                            <h2>Диагностические центры во всех районах Санкт-Петербурга</h2>
                            <div class="row" >
                                <div class="col-md-12">

                                    <?php

                                    /*$toAdd = '';
                                    $criteria = new CDbCriteria();
                                    $criteria -> compare('ignore_clinic', 0);
                                    $criteria -> compare('partner', 1);
                                    $clinics_to_map = clinics::model() -> findAll($criteria);*/
                                    //$clinics_to_map = clinics::model() -> findAllByAttributes(['partner' => 1]);
                                    foreach ($clinics_to_map as $clinic) {
                                        if ($clinic -> map_coordinates) {
                                            $temp = [
                                                "hintContent" => $clinic -> name.', '.$clinic->address
                                            ];
                                            $toAdd .= "{$clinic -> verbiage} = new ymaps.Placemark( [{$clinic -> map_coordinates}] , ".json_encode($temp).");";
                                            $toAdd .= $clinic -> verbiage.".events.add('click', function(e) {
                                                onClinicSelected($clinic->id);
                                            });";
                                            $toAdd .= "window.allClinicsMapBig.geoObjects.add({$clinic -> verbiage});";
                                        }
                                    }
                                    Yii::app()->getClientScript()->registerScript("map_init","

                                        ymaps.ready(function () {
                                        window.allClinicsMapBig = new ymaps.Map('map', {
                                        center: [59.939095, 30.315868],
                                        zoom: 10
                                        }, {
                                        searchControlProvider: 'yandex#search'
                                        });
                                        ".$toAdd."

                                        });
                                        function BigMapCorrect() {
                                            //alert('fit!');
                                            //window.allClinicsMapBig.fitToViewport();
                                        }
                                        var resizeTimer = false;
                                        if (window.allClinicsMapBig) {
                                            cleaTimeout(resizeTimer);
                                            resizeTimer = setTimeout(BigMapCorrect, 500);
                                        }
                                        ",CClientScript::POS_READY);
                                    ?>

                                    <div id="map" style="width:80%; height:500px; margin:0 auto;">
                                    </div>
                                    <?php CustomFlash::showFlashes(); ?>
                                </div>

                                <!--<span class="clinicSliderArrow" id="clinicsSliderPrev"><i class="fa fa-angle-left"></i></span>
                                <span class="clinicSliderArrow" id="clinicsSliderNext"><i class="fa fa-angle-right"></i></span>-->
								<p>&nbsp;</p>
                                <p class="left-images-block-header">
                                    Кликните на указатель на карте, чтобы посмотреть информацию о выбранной клинике!
                                </p>
								<p>&nbsp;</p>
                                <div id="clinicChangeableContainer" class="col-md-12">

                                    <!--<div id="topClinicContainer" class="col-md-12">
                                    </div>-->

                                    <!--<div id="bottomClinicContainer" class="col-md-12">
                                    </div>-->
                                </div>
                                <div class="clear" ></div>
                                <div id="clinicsCarousel" style="position:relative;">

                                </div>
                                <div class="clear" ></div>
                                <div id="reviews" style="margin-top:-25px"></div>
                            </div>
                        </section>

                        <!---->
                        <div class="clear"></div>
                        <div class="line"></div>
                    </div>
                </div>
                <section>
                    <?php
                      //  $c = new Controller();
                    //$c -> renderPartial()
                        $this -> renderPartial('//landingLike/clinicsBottom',['showAll' => 1, 'model' => clinics::model() -> find()]);
                    ?>
                </section>
                <section id="doctora">
                    <h1>Наши врачи</h1>

                    <div class="slider_container">

                        <div class="next_button"><i class="fa fa-angle-right"></i></div>
                        <div class="prev_button"><i class="fa fa-angle-left"></i></div>
                        <div class="carousel-doctors">
                            <?php
                            foreach (doctors::model() -> findAll() as $doctor) {
                                ?>
                                <div class="slide_item">
                                    <div class="doctor">
                                        <?php
                                        $url = $doctor -> giveImageFolderRelativeUrl() . $doctor -> logo;
                                        //echo $url;
                                        if ((file_exists($doctor -> giveImageFolderAbsoluteUrl() . $doctor -> logo)&&($doctor -> logo))) :
                                            //if (true) :
                                            ?>
                                            <div class="doctor-img"><img alt="<?php echo $doctor -> verbiage; ?>" src="<?php echo $url;?>"></div>
                                        <?php endif; ?>
                                        <h4><?php echo $doctor -> name; ?></h4>
                                        <p><?php echo $doctor -> description; ?></p>
                                    </div>
                                </div>
                                <?
                            }
                            ?>
                        </div>

                    </div>
                </section>
                <!---->
                <div class="clear"></div>
                <div class="line"></div>

                <!--FAQ
                <h2 id="faq">Вопросы и ответы</h2>
                <div class="questions-answers">
                    <div class="line"></div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">Что покажет МРТ и/или КТ? Когда нужно проходить МРТ и/или КТ диагностику – показания к проведению исследования? </p>
                            <div class="answer">
                                МРТ подходит, если Вам нужно получить полную картину по заболеванию, поставить точный диагноз, вовремя начать лечение и проследить за его результатами. МРТ помогает:
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">Где лучше пройти МРТ и/или КТ исследование?</p>
                            <div class="answer">
                                В Санкт-Петербурге более 100 диагностических центров, где можно пройти МРТ или КТ диагностику. Данные центры сильно отличаются по ценовой политике и качеству предоставляемых услуг.
                                Нужно понимать, что в МРТ и КТ диагностике очень большое значение имеет опыт врача, описывающего исследование и его специализация. В одних диагностических центрах врачи в большей мере специализируются на одних исследованиях (например: МРТ головного мозга), а в других на иных (например: КТ перфузия). Данная информация не лежит на поверхности и часто врач, направивший пациента на МРТ или КТ диагностику, сам может не знать всех тонкостей проведения данной процедуры, а также в каких диагностических центрах, какие врачи работают (их сильные и слабые профессиональные стороны). Поэтому для правильного выбора медицинского центра МРТ и/или КТ диагностики самым правильным решением будет обратиться за помощью к профессионалам - Общегородская служба записи на МРТ и КТ исследования, обратившись к нам, пациент получит:
                                Бесплатную консультацию по общим вопросам, касающимся МРТ и КТ диагностики.
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">Какова длительность МРТ и/или КТ исследования?</p>
                            <div class="answer">
                                <div class="line"></div>
                                МРТ и КТ основаны на разных физических принципах. Именно это является причиной различия во времени проведения исследований: ̴ 5 минут бесконтрастное исследование, с контрастом̴ 30 минут, а МРТ исследование проводится значительно дольше: ̴ 30 минут бесконтрастное исследование, с контрастом̴ 60 минут.
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">В чем разница между МРТ и КТ диагностикой?</p>
                            <div class="answer">
                                Получение изображения при проведении МРТ исследовании основано на взаимодействии
                                магнитного поля с телом пациента. A при КТ томографии на взаимодействии (просвечивании)
                                тела пациента рентгеновскими лучами, по сути КТ это продвинутая флюшка. В предыдущем
                                вопросе были рассмотрены случаи, когда правильнее пройти МРТ обследование, а когда КТ будет
                                предпочтительней..
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">Какова длительность МРТ и/или КТ исследования?</p>
                            <div class="answer">
                                МРТ и КТ основаны на разных физических принципах. Именно это является причиной различия во времени проведения исследований: ̴ 5 минут бесконтрастное исследование, с контрастом̴ 30 минут, а МРТ исследование проводится значительно дольше: ̴ 30 минут бесконтрастное исследование, с контрастом̴ 60 минут.
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">В чем разница между МРТ и КТ диагностикой?</p>
                            <div class="answer">
                                Получение изображения при проведении МРТ исследовании основано на взаимодействии
                                магнитного поля с телом пациента. A при КТ томографии на взаимодействии (просвечивании)
                                тела пациента рентгеновскими лучами, по сути КТ это продвинутая флюшка. В предыдущем
                                вопросе были рассмотрены случаи, когда правильнее пройти МРТ обследование, а когда КТ будет
                                предпочтительней..
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">Какова длительность МРТ и/или КТ исследования?</p>
                            <div class="answer">
                                МРТ и КТ основаны на разных физических принципах. Именно это является причиной различия во времени проведения исследований: ̴ 5 минут бесконтрастное исследование, с контрастом̴ 30 минут, а МРТ исследование проводится значительно дольше: ̴ 30 минут бесконтрастное исследование, с контрастом̴ 60 минут.
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">В чем разница между МРТ и КТ диагностикой?</p>
                            <div class="answer">
                                Получение изображения при проведении МРТ исследовании основано на взаимодействии
                                магнитного поля с телом пациента. A при КТ томографии на взаимодействии (просвечивании)
                                тела пациента рентгеновскими лучами, по сути КТ это продвинутая флюшка. В предыдущем
                                вопросе были рассмотрены случаи, когда правильнее пройти МРТ обследование, а когда КТ будет
                                предпочтительней..
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">Какова длительность МРТ и/или КТ исследования?</p>
                            <div class="answer">МРТ и КТ основаны на разных физических принципах. Именно это является причиной различия во времени проведения исследований: ̴ 5 минут бесконтрастное исследование, с контрастом̴ 30 минут, а МРТ исследование проводится значительно дольше: ̴ 30 минут бесконтрастное исследование, с контрастом̴ 60 минут.
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                    <div class="question-answer">
                        <div class="question">
                            <p class="question-title">В чем разница между МРТ и КТ диагностикой?</p>
                            <div class="answer">
                                Получение изображения при проведении МРТ исследовании основано на взаимодействии
                                магнитного поля с телом пациента. A при КТ томографии на взаимодействии (просвечивании)
                                тела пациента рентгеновскими лучами, по сути КТ это продвинутая флюшка. В предыдущем
                                вопросе были рассмотрены случаи, когда правильнее пройти МРТ обследование, а когда КТ будет
                                предпочтительней..
                            </div>
                            <a class="toggle-answer">Посмотреть ответ</a>
                        </div>
                    </div>
                </div>
                <!--/FAQ-->

                <div class="promocode left-images-block coll-box">
                    <div class="order-form">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-4"><input type="text" class="your-name" name="name" placeholder="Ваше имя.." pattern=".+" required=""></div>
                                <div class="col-md-4"><input type="text" class="your-phone"  name="phone" placeholder="Ваш телефон.." pattern="[0-9-+()\s]{8,20}$" required=""></div>
                                <div class="col-md-4"><input type="submit" name="submit" value="записаться" class="submit"></div>
                            </div>
                        </form>
                    </div>
                    <p class="left-images-block-header"> Многоканальный телефон для записи на МРТ или КТ исследование: </p>
                    <p><a class="callcenter-phone" href="tel:8812<?=CallTrackerModule::getShortNumber();?>"><?php echo CallTrackerModule::getFormattedNumber();?></a></p>
                </div>

            </div>
        </div>
    </div>
</div>


<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div><a href="<?php echo $base; ?>/?mobile=1" class="changeVersion">Перейти к мобильной версии</a></div>
                <span>© 2012-2016, Самая крупная сеть <strong>МРТ</strong> и <strong>КТ</strong> диагностических центров в СПб</span>
            </div>
        </div>
    </div>
</footer>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<div class="hidden">
    <form id="callback-registration" class="pop_form">
        <h3>Записаться на МРТ и КТ</h3>
        <div class="registradion-block">
			<div class="variable">
				<p>Вам перезвонят в течении 5 минут!</p>
				<p>Специалист-диагност подберет Вам подходящую клинику и наилучшую цену, а также запишет на обследование в удобное для Вас время.</p>
				<p>Ответит на все вопросы, связанные с МРТ и КТ диагностикой.</p>
			</div>
		</div>
        <input type="text" class="your-name" name="name" placeholder="Ваше имя..." required />
        <input type="text" class="your-phone" name="phone" placeholder="Ваше телефон..." required />
        <button class="order-button" name="your-name" value="" type="submit">Записаться</button>
		<a title="Close" class="fancybox-item fancybox-close" href="#"></a>
    </form>
</div>

</body>
</html>