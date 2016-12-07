<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.12.2016
 * Time: 16:13
 */
$base = Yii::app() -> baseUrl;
$baseTheme = Yii::app() -> theme -> baseUrl;
$clinics_to_map = clinics::model() -> findAllByAttributes(['ignore_clinic' => '0', 'partner' => '1']);

Yii::app() -> getClientScript() -> registerScript('defineBase','
    baseUrl="'.$base.'";
    baseUrlTheme="'.$baseTheme.'";
',CClientScript::POS_BEGIN);
Yii::app() -> getClientScript() -> registerScriptFile($base.'/jsLandingLike/jquery-1.11.1.min.js',CClientScript::POS_BEGIN);
Yii::app() -> getClientScript() -> registerScriptFile($base."/jsLandingLike/jquery.maskedinput.min.js",CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScriptFile($base."/fancybox/jquery.fancybox.pack.js",CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScriptFile($baseTheme."/jsLandingLike/common.js",CClientScript::POS_END);
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
            if (!price) {
                price = 100;
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


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>Самая крупная сеть МРТ и КТ диагностических центров в СПб</title>
    <meta name="description" content="Каталог клиник МРТ и КТ" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width; initial-scale=0.85; maximum-scale=0.85; user-scalable=0;" />
    <link rel="shortcut icon" href="<?php echo $base; ?>/imgLandingLike/favicon.png" />
    <link rel="stylesheet" href="<?php echo $base; ?>/cssLandingLike/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $base; ?>/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="<?php echo $baseTheme; ?>/cssLandingLike/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $baseTheme; ?>/cssLandingLike/main.css" />
    <link rel="stylesheet" href="<?php echo $baseTheme; ?>/cssLandingLike/media.css" />
    <!--new styles for small screen-->
    <link rel="stylesheet" href="<?php echo $baseTheme; ?>/cssLandingLike/mediastyles.css" />
</head>
<body>
<!--boostrap collapse for prices and comments-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                var yaParams = <?php $params = CallTrackerModule::getExperiment() -> getParams(); $params['design'] = 'mobile'; echo json_encode($params); ?>;
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
                <!--button class="main_mnu_button hidden-md hidden-lg"><i class="fa fa-bars"></i></button-->
                <ul>
                    <li class="discount-sale top-phone"><a class="fancybox" href="#callback-registration" target="_blank"><img alt="Записаться" src="<?php echo $base; ?>/imgLandingLike/top-phone.png">Запись <br /> на МРТ и КТ
                            <span class="menu-desc">24 часа!</span>
                        </a>
                    </li>
                    <li class="discount-sale hidden-sm hidden-xs"><a href="#hot-offers"><span class="menu-title"><i class="fa fa-percent" aria-hidden="true"></i><img alt="" src="<?php echo $base; ?>/imgLandingLike/percent.png">Самые горячие<br /> предложения по СПб</span><span class="menu-desc">Скидки и Акции</span></a></li>
                    <li class="our-centers hidden-sm hidden-xs"><a href="#centers"><span class="menu-title">Наши <br />Центры</span></a></li>
                    <li class="our-prices hidden-sm hidden-xs"><a href="#prices"><span class="menu-title">Наши<br /> Цены</span></a></li>
                    <li class="our-phone hidden-sm hidden-xs"><a href="#callback-registration" class="order fancybox"><span class="menu-title"><?php echo CallTrackerModule::getFormattedNumber();?></span>
                            <img src="<?php echo $base; ?>/imgLandingLike/phone-sm.png" alt="" /><span class="menu-desc">Заказать обратный звонок</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <aside class="col-md-12 ">
            <div class="aside-block">

                    <!--media screen-->
                    <div class="media-screen">
                        <!--Записаться на МРТ и КТ-->

                        <marquee behavior="scroll" direction="left" scrollamount="5">МРТ и КТ рядом с домом - во всех районах города!</marquee>

                        <div class="left-images-block coll-box">
                            <p class="left-images-block-header">Записаться на прием по телефону: </p>
                            <p><a class="callcenter-phone" href="tel:8812<?=CallTrackerModule::getShortNumber();?>"><?php echo CallTrackerModule::getFormattedNumber();?></a></p>
                            <p><strong>Врач-консультант перезвонит вам в течение 10 минут!</strong></p>
                            <p>или</p>
                            <div class="order-form">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-12"><input type="text" class="your-name" name="name" placeholder="Ваше имя.." pattern=".+" required=""></div>
                                        <div class="col-md-12"><input type="text" class="your-phone"  name="phone" placeholder="Ваш телефон.." pattern="[0-9-+()\s]{8,20}$" required=""></div>
                                        <div class="col-md-12"><input type="submit" name="submit" value="Оставить заявку" class="submit"></div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!--collapse-->
                        <div id="collapse">
                            <button class="btn btn-primary mine_tab" data-toggle="collapse" data-mine_tab_selector="#mrt">Цены МРТ</button>
                            <button class="btn btn-primary mine_tab" data-toggle="collapse" data-mine_tab_selector="#kt">Цены КТ</button>
                            <button class="btn btn-primary mine_tab last" data-toggle="collapse" data-mine_tab_selector="#comments">Отзывы о нас</button>

                            <?php
                            $this -> renderPartial('//landingLike/prices_collapse', ['base' => $base]);
                            ?>

                            <div id="comments" class="collapse">
                                <div class="tab_container">
                                    <?php
                                    //  $c = new Controller();
                                    //$c -> renderPartial()
                                    $this -> renderPartial('//landingLike/clinicsBottom',['showAll' => 1, 'model' => clinics::model() -> find()]);
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!--Нaши Преимущества-->
                        <div class="line"></div>
                        <div class="row advantages">
                            <div class="col-md-3">
                                <img src="<?php echo $base; ?>/imgLandingLike/advantage1.png" alt="" />
                                <span>МРТ и КТ<br /> срочно</span>
                            </div>
                            <div class="col-md-3">
                                <img src="<?php echo $base; ?>/imgLandingLike/advantage2.png" alt="" />
                                <span>мрт и кт ночью<br /> скидка 50%</span>
                            </div>
                            <div class="col-md-3">
                                <img src="<?php echo $base; ?>/imgLandingLike/advantage3.png" alt="" />
                                <span>Результат<br /> за час</span>
                            </div>
                            <div class="col-md-3">
                                <img src="<?php echo $base; ?>/imgLandingLike/advantage5.png" alt="" />
                                <span>бесплатная консультация<br /> невролога и травмотолога</span>
                            </div>
                        </div>

                        <div class="line"></div>

                        <!--Баннер оборудование-->
                        <div class="banner" id="oborud">
                            <div class="row">
                                <div class="col-sm-6 col-xs-6">
                                    <!--Баннер 1-->
                                    <div class="left-images-block">
                                        <a href="#">
                                            <div>
                                                <p>
                                                    <span>МРТ на Аппарате 3 Тесла</span>
                                                    <span class="banner-big-font">по самой низкой</span>
                                                    <span class="banner-big-font banner-blue-font">цене в городе</span>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-6">
                                    <!--Баннер 2-->
                                    <div class="left-images-block">
                                        <a href="#">
                                            <div>
                                                <p><span>МРТ томографы 1.5 Тл, полуоткрытого типа -</span><br />
                                                    <span class="banner-big-font">оборудование </span><span class="banner-big-font banner-blue-font">экспертного класса!&nbsp;</span></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-6">
                                    <!--Баннер 3-->
                                    <div class="left-images-block">
                                        <a href="#">
                                            <div>
                                                <p><span>МРТ аппарат открытого типа -</span>
                                                    <span class="banner-blue-font">прием ведет Профессор кафедры лучевой диагностики,</span><br />
                                                    <span class="banner-big-font">доктор медицинских наук.&nbsp;</span></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-6">
                                    <!--Баннер 4-->
                                    <div class="left-images-block">
                                        <a href="#">
                                            <div>
                                                <p><span>128 срезовый компьютерный томограф – </span>
                                                    <span class="banner-big-font banner-blue-font">лучший аппарат в городе!&nbsp;</span></p>
                                            </div>
                                        </a>
                                    </div>
                                    <!--/Баннер 4-->
                                </div>
                            </div>
                        </div>
                        <!--Записаться еще раз -->
                        <div class="left-images-block coll-box">
                            <p class="left-images-block-header"> Многоканальный телефон для записи на МРТ или КТ исследование: </p>
                            <p><a class="callcenter-phone" href="tel:8812<?=CallTrackerModule::getShortNumber();?>"><?php echo CallTrackerModule::getFormattedNumber();?></a></p>
                            <div class="order-form">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-12"><input type="text" class="your-name" name="name" placeholder="Ваше имя.." pattern=".+" required=""></div>
                                        <div class="col-md-12"><input type="text" class="your-phone"  name="phone" placeholder="Ваш телефон.." pattern="[0-9-+()\s]{8,20}$" required=""></div>
                                        <div class="col-md-12"><input type="submit" name="submit" value="Оставить заявку" class="submit"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--/media screen-->
            </div>
        </aside>
    </div>
</div>


<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div><a href="<?php echo $base; ?>/?fullscreen=1" class="changeVersion">Перейти к полной версии</a></div>
                <span>© 2012-<?php echo date('Y'); ?>, Самая крупная сеть <strong>МРТ</strong> и <strong>КТ</strong> диагностических центров в СПб</span>
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
        <p>Вам перезвонят в течении 5 минут!</p>
        <p>Специалист-диагност подберет Вам подходящую клинику и наилучшую цену, а также запишет на обследование в удобное для Вас время.</p>
        <p>Ответит на все вопросы, связанные с МРТ и КТ диагностикой.</p>
        <input type="text" class="your-name" name="name" placeholder="Ваше имя..." required />
        <input type="tel" class="your-phone" name="phone" placeholder="Ваше телефон..." required />
        <button class="order-button" name="your-name" value="" type="submit">Записаться</button>
    </form>
</div>
</body>
</html>