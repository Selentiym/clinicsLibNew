<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2016
 * Time: 15:37
 */

$base = Yii::app() -> baseUrl;
Yii::app() -> getClientScript() -> registerScriptFile($base.'/js/jquery-1.11.1.min.js',CClientScript::POS_BEGIN);
Yii::app() -> getClientScript() -> registerScriptFile($base.'/js/jquery.maskedinput.min.js',CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScriptFile($base.'/fancybox/jquery.fancybox.pack.js',CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScriptFile($base.'/js/common.js',CClientScript::POS_END);
Yii::app() -> getClientScript() -> registerScript('defineBase','
    baseUrl="'.$base.'";
',CClientScript::POS_BEGIN);
Yii::app() -> getClientScript() -> registerScript('sendForms','
    $(".standard-form, #callback-registration").submit(function(event) {
        var turner = $(this).find("input[type=\'submit\'], button");
        turner.prop("disabled",true);
        $.post(baseUrl+"/post",$(this).serialize()).done(function(date){
            alert("Ваша заявка успешно принята!");
            turner.prop("disabled",false);
        }).fail(function(){
            alert("Возникла ошибка при отправке. Пожалуйста, попробуйте еще раз или воспользуйтесь одним из указанных телефонных номеров.");
            turner.prop("disabled",false);
        });
        return false;
    });
',CClientScript::POS_READY);
Yii::app() -> getClientScript() -> registerScript('bigScriptOnLoad','
jQuery(function($){
    $(".your-phone").mask("+7(999)999-99-99");
});', CClientScript::POS_READY);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>Каталог клиник МРТ и КТ</title>
    <meta name="description" content="Каталог клиник МРТ и КТ" />
	<link rel="shortcut icon" href="img/favicon.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>	<link rel="shortcut icon" href="favicon.png" />
    <link rel="stylesheet" href="<?=$base?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?=$base?>/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?=$base?>/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="<?=$base?>/css/main.css" />
    <link rel="stylesheet" href="<?=$base?>/css/media.css" />
</head>
<body>
<header>
    <div class="container">
        <div class="row header_topline">
            <div class="col-md-4 col-xs-9">
                <a class="logo" href="<?=$base?>/?clear=1">
                    <img alt="" src="<?=$base?>/img/logo.png">
                    <span>Полный каталог <span>МРТ</span> и <span>КТ</span><br> клиник Cанкт-Петербурга</span>
                </a>
            </div>
            <nav class="col-md-8 col-xs-3 main_menu clearfix">
                <button class="main_mnu_button hidden-md hidden-lg"><i class="fa fa-bars"></i></button>
                <ul>
                    <li class="discount"><a href="<?=$base?>/discount"><span class="menu-title"><i class="fa fa-percent" aria-hidden="true"></i><img alt="" src="<?=$base?>/img/percent.png">Самые горячие предложения по СПб</span><span class="menu-desc">Скидки и Акции</span></a></li>
                    <li><a href="<?=$base?>/faq"><span class="menu-title"><i class="fa fa-question-circle" aria-hidden="true"></i>Все об МРТ и КТ ...</span><span class="menu-desc">МРТ или КТ, подготовка, противопоказания и ограничения</span></a></li>
                    <li><a href="<?=$base?>/bigMap"><span class="menu-title"><i class="fa fa-book" aria-hidden="true"></i>Каталог клиник</span><span class="menu-desc">Лучшие клиники CПб, поиск по цене,<br> расположению и другим параметрам</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<div class="container">
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter40204894 = new Ya.Metrika({
                        id:40204894,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
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
    <div class="row">
        <aside class="col-md-4 ">
            <div class="aside-block">
                <div class="left-images-block">
                    <p class="left-images-block-header"> Вы можете обратиться в <b>бесплатный консультативный центр</b>, где&nbsp;специалист&#8209;диагност:</p>
                    <ul class="red-label">
                        <li>Абсолютно бесплатно подберет Вам оптимально <b>подходящую клинику</b> и <b>наилучшую цену</b>, а также запишет Вас на обследование в удобное для Вас время.</li>
                        <li>Ответит на все вопросы, связанные с МРТ и КТ диагностикой.</li>
                    </ul>
                    <p class="callcenter">Телефон колл-центра:<br><a class="callcenter-phone" href="tel:8812<?=CallTrackerModule::getShortNumber();?>"><?php echo CallTrackerModule::getFormattedNumber();?></a></p>
                    <p style="text-align:center">или заполните форму:</p>
                    <div class="order-form">
                        <form method="post" class="standard-form">
                            <div class="row">
                                <div class="col-md-12"><input type="text" class="your-name" name="name" placeholder="Ваше имя.." pattern="^.+$" required=""></div>
                                <div class="col-md-12"><input type="text" class="your-phone"  name="phone" placeholder="Ваш телефон.." pattern="[0-9-+()\s]{8,20}$" required=""></div>
                                <div class="col-md-12"><input type="submit" name="submit" value="Оставить заявку" class="submit"></div>
                            </div>
                        </form>
                    </div>
                    <p style="text-align:center">Врач-консультант перезвонит вам в течение 10 минут!</p>

                </div>
                <div class="review-outer"><div class="review-inner">В ряд диагностических клиник города, запись на исследование через бесплатный консультативный центр дешевле, чем запись в клинику напрямую! </div></div>
                <div class="tags-block" id="tags-block">
                    <div class="tags-block-inner">
                        <h4>Поиск по параметрам</h4>
                        <div class="line" style="margin-bottom: 0;"></div>
                        <div class="tags-block_group blue">
                            <div class="tags-block_group_header">Подбор клиники по исследованиям:</div>
                            <a href="<?=$base?>/clinics/research/1"><b>Головной мозг</b></a>
                            <a href="<?=$base?>/clinics/research/2">Гипофиз</a>
                            <a href="<?=$base?>/clinics/research/3">Нервы</a>
                            <a href="<?=$base?>/clinics/research/4">Носовые пазухи</a>
                            <a href="<?=$base?>/clinics/research/5">Сосуды - ангиография</a>
                            <a href="<?=$base?>/clinics/research/6">Орбиты</a>
                            <a href="<?=$base?>/clinics/research/7">Шея</a>
                            <a href="<?=$base?>/clinics/research/8">Горло и гортань</a>
                            <a href="<?=$base?>/clinics/research/9"><b>Позвоночник</b></a>
                            <a href="<?=$base?>/clinics/research/10"><b>Суставы</b></a>
                            <a href="<?=$base?>/clinics/research/11"><b>Легкие</b></a>
                            <a href="<?=$base?>/clinics/research/12"><b>Грудная клетка</b></a>
                            <a href="<?=$base?>/clinics/research/13">Конечности</a>
                            <a href="<?=$base?>/clinics/research/14"><b>Брюшная полость</b></a>
                            <a href="<?=$base?>/clinics/research/15">Холангиография</a>
                            <a href="<?=$base?>/clinics/research/16">Забрюшинное пространство</a>
                            <a href="<?=$base?>/clinics/research/17"><b>Малый таз</b></a>
                            <a href="<?=$base?>/clinics/research/18">Отдельные органы</a>
                            <a href="<?=$base?>/clinics/research/19">МРТ и КТ с контрастом</a>
                        </div>
                        <div class="line" style="margin-bottom: 0;"></div>
                        <div class="tags-block_group lightblue">
                            <div class="tags-block_group_header">Специализированные исследования:</div>
                            <?php
                                $ids = [11,12,13,14,15,16,17,18];
                                foreach (TriggerValues::model() -> findAllByPk($ids) as $tr) {
                                    echo "<a href='$base/clinics/seldom/$tr->id'><b>$tr->value</b></a>";
                                }
                            ?>
                        </div>
                        <div class="line" style="margin-bottom: 0;"></div>
                        <div class="tags-block_group blue">
                            <div class="tags-block_group_header">Подбор клиники по параметрам оборудования:</div>
                            <?php
                            $ids = [1,8,2,7,9,3,6,4,10,5];
                            foreach (TriggerValues::model() -> findAllByPk($ids) as $tr) {
                                echo "<a href='$base/clinics/equipment/$tr->id'><b>$tr->value</b></a>";
                            }
                            ?>
                        </div>
                        <div class="line" style="margin-bottom: 0;"></div>
                        <div class="tags-block_group lightblue">
                            <div class="tags-block_group_header">Подбор клиники по дополнительным параметрам:</div>
                            <a href="<?=$base?>/clinics/dopParams/1"><b>Без ограничений по весу</b></a>
                            <a href="<?=$base?>/clinics/dopParams/2">Исследования ночью</a>
                            <a href="<?=$base?>/clinics/dopParams/3"><b>Круглосуточно</b></a>
                            <a href="<?=$base?>/clinics/dopParams/4">Скидки</a>
                            <a href="<?=$base?>/clinics/dopParams/5">Акции</a>
                            <a href="<?=$base?>/clinics/dopParams/6">МРТ дешево</a>
                            <a href="<?=$base?>/clinics/dopParams/7"><b>Лучшие врачи</b></a>
                            <a href="<?=$base?>/reviews/best"><b>Лучшие отзывы</b></a>
                        </div>
                        <div class="line" style="margin-bottom: 0;"></div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-md-8">
            <div id="content" class="main_page">
                <?php echo $content; ?>
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
                <span>© 2012-2016, Полный каталог клиник МРТ и КТ в Санкт-Петербурге</span>
            </div>
        </div>
    </div>
</footer>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--<div class="filter-mob">
    <div class="select-outer">
        <select id="region_mob" name="region_mob" size="1">
            <option>
                Район СПб
            </option>
            <option>
                Район 1
            </option>
            <option>
                Район 2
            </option>
            <option>
                Район 3
            </option>
            <option>
                Район 4
            </option>
        </select>
        <a class="select-button"></a>
    </div>
    <div class="select-outer">
        <select id="subway_mob" name="subway_mob" size="1">
            <option>
                Метро СПб
            </option>
            <option>
                Станция 1
            </option>
            <option>
                Станция 2
            </option>
            <option>
                Станция 3
            </option>
            <option>
                Станция 4
            </option>
        </select>
        <a class="select-button"></a>
    </div>
    <div class="select-outer">
        <select id="price_mob" name="price_mob" size="1">
            <option>
                Цена
            </option>
            <option>
                Сначала дешевле
            </option>
            <option>
                Сначала дороже
            </option>
        </select>
        <a class="select-button"></a>
    </div>
</div>-->

<a href="<?=$base?>/clinics?clear=1" class="quick-jump">В каталог!</a>

<div class="hidden">
    <form id="callback-registration" class="pop_form">
        <h3>Записаться на МРТ и КТ</h3>
        <p>Врач-консультант перезвонит вам в течение 10 минут!</p>
        <p>Вы сможете получить подробную консультацию по всем вопросам, связанным с МРТ и КТ исследованием и при желании записаться на обследование в удобное для вас время по лучшей цене!</p>
        <input type="text" class="your-name" name="name" placeholder="Ваше имя..." required />
        <input type="text" class="your-phone" name="phone" placeholder="Ваше телефон..." required />
        <button class="order-button" name="your-name" value="" type="submit">Записаться</button>
    </form>
</div>

</body>
</html>
