<!DOCTYPE html>
<html class=" js no-touch">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache"> <!-- Временный запрет кеширования. УБРАТЬ! -->
<meta name="language" content="en" />
<?php //Yii::app()->bootstrap->register(); ?>

<?php $cs = Yii::app()->getClientScript(); ?>

<?php $cs -> registerCssFile(Yii::app()->baseUrl.'/css/MainPageStyles.css'); ?>


<?php $cs -> registerScriptFile(Yii::app()->baseUrl.'/js/jquery.dropdownPlain.js'); ?>

<!--<link rel = "stylesheet" href="<?php echo Yii::app()->baseUrl.'/css/MainPageStyles.css'; ?>">-->
<title><?php echo Yii::app()->name . ' - Главная'; ?></title>
<!--<link rel="shortcut icon" href="http://spb.medbooking.com/favicon.png" type="image/x-icon"> полезно!-->

<!--[if lte IE 8]><script src="http://spb.medbooking.com/scripts/modernizr-2.6.2-respond-1.1.0.min.js"></script><link rel="stylesheet" href="http://spb.medbooking.com/styles/css/ie8.css"><![endif]-->
<!--[if lte IE 9]><script src="http://spb.medbooking.com/scripts/jquery.placeholder.min.js"></script><![endif]-->

<!--<meta name=viewport content="width=device-width, initial-scale=1">-->
<!--<script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>-->
</head>
<body>

<div class="window-opacity"></div>
<section class="wrapper fix-width">
    <header id="header" class="inner header_block clearfix">
    <div class="left_inner_header_block left">
        <a href="<?php echo Yii::app() -> baseUrl; ?>" class="logo"><img src="<?php echo Yii::app() -> baseUrl. '/images/logo.bmp' ?>" alt="logo"></a>

    </div>
	<!--<div class="ya-site-form ya-site-form_inited_no right_inner_header_block right big" onclick="return {'action':'http://cq97848.tmweb.ru/search','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по ...','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2230691,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'Введите запрос','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}">
		<form class="header_search_form" action="http://yandex.ru/sitesearch" method="get" target="_self">
			<input type="hidden" name="searchid" value="2230691"/>
			<input type="hidden" name="l10n" value="ru"/>
			<input type="hidden" name="reqenc" value=""/>
			<input type="search" name="text" value=""/>
			<input type="submit" value="Найти"/>
		</form>
	</div>-->
</header>
    <section id="content" class="clearfix">
        <section id="info_container" class="info_container items clearfix">
    <div class="left item info_container_item">
        <div class="number">104</div>
		<div>text</div>
    </div>
    <div class="left item info_container_item">
        <div class="number">1477</div>
		<div>text</div>
    </div>
    <div class="left item info_container_item">
        <div class="number">3603</div>
		<div>text</div>
    </div>
    <div class="left item info_container_item">
        <div class="number">272</div>
		<div>text</div>
    </div>
	<div class="left item info_container_item">
        <div class="number">272</div>
		<div>text</div>
    </div>
</section>
<div id="new_header">
<nav class="clearfix">
        <div class="inner_fix_width new_infopage_blog_single clearfix">
            <span class="main_list_icon js_main_list_icon"></span>
			<?php
				//echo Yii::getpathOfAlias('ext.widgets.dropdown');
				//echo Yii::getpathOfAlias('webroot');
				//echo "asfsfds";
				$this -> widget('ext.widgets.dropdown.DropDownMenu', array(
					'items'=>MenuButtons::model() -> giveMenu(),
					'viewFirstLevel'=>'//home/nav/_menu_item1',
					'viewSecondLevel'=>'//home/nav/_menu_item2',
					'viewThirdLevel'=>'//home/nav/_menu_item3',
					'htmlOptions' => array('class' => 'important_page_links clearfix left'),
					'registerCss' => false
				));
			?>
        </div>
</nav>
</div>
<!--<section id="search" class="index">

    <div class="label clearfix"><span class="">Найдите своего врача или клинику</span><span class="">Запишитесь на прием on-line!</span></div>
    <form id="form-sel-sel" class="form_items" action="http://spb.medbooking.com/doctors" method="get">    <div class="fake-select-wrapper index_form clearfix">
        <div class="fake_select face-select-category select_category left" data-href="/ajax/category">
            <input type="text" placeholder="Выберите специалиста" name="category" class="category-select" id="category_id" value="" readonly="">
            <input type="hidden" name="category_translit" class="category-translit-select" id="category_translit_id" value="">
        </div>
        <div class="fake_select face-select-subway select_location left" data-href="/ajax/subway">
            <input type="text" placeholder="Выберите ст.метро" name="subway" class="subway-select" id="subway_id" value="" readonly="">
            <input type="hidden" name="subway_translit" class="subway-translit-select" id="subway_translit_id" value="">
            <input type="hidden" name="district" class="district" id="district_id" value="">
        </div>
        <div class="form_item left">
            <input style="display:none;" type="submit" name="yt0" value="">            <a class="search-btn btn search_btn" href="http://spb.medbooking.com/doctors">Найти</a>
        </div>
    </div>
</form>
</section>-->
<section id="index_list" class="index_list list inner left">
    <div class="column-doctors-left left item index_list_item">
<?php
	$this -> renderPartial('//articles/show_all', array('articles' => $articles));
?>
    </div>

</section>
<aside class="right index_right">
    <div id="icon_link" class="spb_icon_link right_block block_list index">
    <ul class="icon_link_items">
        <?php
			foreach($RightTexts as $rt)
			{
				$this -> renderPartial('//main/RightText', array('view' => $rt -> giveViewInfo()));
			}
		?>
    </ul>
</div>
</aside>
    <section class="popular_blogs">
        <div class="popular_blogs_title">Популярные записи в медицинском блоге</div>
        <div class="popular_blogs_items clearfix">
			<?php
				foreach($HorizontalTexts as $ht)
				{
					$this -> renderPartial('//main/HorizontalText', array('view' => $ht -> giveViewInfo()));
				}
			?>
		</div>
    </section>
<section class="common_diseases clearfix">
	<div id="main_text">
		<?php echo $main_text; ?>
	</div>
<!--<div class="common_diseases_title">Распространенные заболевания</div>
    <ul class="common_diseases_items column1">
                <li class="common_diseases_item"><a href="http://medbooking.com/illness/opushhenije-matki" target="_blank">Опущение матки</a></li>
                <li class="common_diseases_item"><a href="http://medbooking.com/illness/opojasyvajushhij-lishaj" target="_blank">Опоясывающий лишай</a></li>
                <li class="common_diseases_item"><a href="http://medbooking.com/illness/opistorkhoz" target="_blank">Описторхоз</a></li>
            </ul>
    <ul class="common_diseases_items column2">
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/ooforit" target="_blank">Оофорит</a></li>
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/onihomikoz" target="_blank">Онихомикоз</a></li>
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/oligofrenija" target="_blank">Олигофрения</a></li>
            </ul>
    <ul class="common_diseases_items column3">
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/oligoastenoteratozoospermija" target="_blank">Олигоастенотератозооспермия</a></li>
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/neprohodimosty-kishechnika" target="_blank">Непроходимость кишечника</a></li>
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/kista-shhitovidnoj-zhelezy" target="_blank">Киста щитовидной железы</a></li>
            </ul>
    <ul class="common_diseases_items column">
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/ushib" target="_blank">Ушиб</a></li>
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/utoplenije" target="_blank">Утопление</a></li>
                    <li class="common_diseases_item"><a href="http://medbooking.com/illness/uzlovataja-eritema" target="_blank">Узловатая эритема</a></li>
            </ul>-->
</section>

    </section>
    <footer id="footer" class="inner footer_block clearfix">
	<table class="middle_inner_footer_block">
		<tbody>
			<tr>
				<td class="social_icons">
					<div class="icon_couple">
					<a href="http://vk.com"><img src="/images/sprite.png" alt="vkontakte"></a>
					<a href="http://facebook.com"><img src="/images/sprite.png" alt="facebook"></a>
					</div>
					<div class="icon_couple">
					<a href="http://twitter.com"><img src="/images/sprite.png" alt="twitter"></a>
					<a href="http://ok.ru"><img src="/images/sprite.png" alt="odnoklassniki"></a>
					</div>
					<div class="icon_couple">
					<a href="http://instagram.com"><img src="/images/sprite.png" alt="instagram"></a>
					<a href="http://plus.google.com"><img src="/images/sprite.png" alt="google"></a>
					</div>
				</td>
				<td class="footer_menu" rowspan=2>
					<ul class="footer-menu footer_links">
					<?php
						foreach($footerMenu as $item) {
							echo "<li>";
							echo CHtml::link($item['text'], $item['url']);
							echo "</li>";
						}
					?>
					</ul>
				</td>
			</tr>
			<tr>
				<td class="center_middle_footer_block"><?php echo $footerText; ?></td>
			</tr>
		</tbody>
	</table>
	<div class="bottom_inner_footer_block">
		<div class="copy">© Сopyright 2015. Все права защищены.</div>
	</div>
    <!--<div class="middle_inner_footer_block clearfix">
        <div class="left_middle_inner_footer_block left">
            <ul>
                <li class="fb"><noindex><a href="http://www.facebook.com/medbooking" target="_blank" class="facebook"></a></noindex></li>
                <li class="tw"><noindex><a href="https://twitter.com/medbookingru" target="_blank" rel="nofollo" class="twitter"></a></noindex></li>
                <li class="vk"><noindex><a href="http://vk.com/medbooking" target="_blank" class="vk"></a></noindex></li>
                <li class="inst"><noindex><a href="http://instagram.com/medbooking" target="_blank" rel="nofollo" class="instagram"></a></noindex></li>
                <li class="gp"><noindex><a target="_blank" href="https://plus.google.com/104496212479886693452" rel="publisher" class="google"></a></noindex></li>
                <li class="ok"><noindex><a target="_blank" href="http://ok.ru/med.booking" rel="publisher" class="odnoklassniki"></a></noindex></li>
            </ul>	
        </div>
        <div class="center_middle_inner_footer_block left">
            <span class="cmi_footer_title">Medbooking.com</span>
            <p class="cmi_footer_note">Любое копирование материалов с данного сайта, без одобрения администрации сайта, будет преследоваться по закону.</p>
            <ul class="cmi_footer_site_links footer_links">
                <li><a target="_blank" href="http://medbooking.com/about">О проекте</a></li>
                <li><a target="_blank" href="http://medbooking.com/forclinics">Клиникам</a></li>
                <li><a target="_blank" href="http://medbooking.com/insurance">Страховым агентам</a></li>
                <li><a target="_blank" href="http://medbooking.com/site/agreement">Пользовательское соглашение</a></li>
                <li><a target="_blank" href="http://medbooking.com/contact">Контакты</a></li>
                <li><a target="_blank" href="http://medbooking.com/rating">Рейтинг</a></li>                
                <li><a target="_blank" href="http://r.medbooking.com/">Рекомендации врачей и клиник</a></li>                
            </ul>
            <p class="cmi_footer_note_email">Все вопросы можно задать по адресу:</p>
            <div class="cmi_footer_email"><a href="mailto:service@medbooking.com">service@medbooking.com</a></div>
        </div>
        <div class="right_middle_inner_footer_block right">
            <ul class="footer-menu footer_links">
                <li><a target="_blank" href="http://medbooking.com/info/pregnancy">Календарь беременности</a></li>
                <li><a target="_blank" href="http://medbooking.com/info/baby">Календарь развития ребенка</a></li>
                <li><a target="_blank" href="http://medbooking.com/blog">Блоги</a></li>
                <li><a target="_blank" href="http://medbooking.com/services">Медицинские услуги</a></li>
                <li><a target="_blank" href="http://medbooking.com/symptoms">Симптомы заболеваний</a></li>
                <li><a target="_blank" href="http://medbooking.com/illness">Справочник заболеваний</a></li>
                <li><a target="_blank" href="http://medbooking.com/patient">Справочник пациента</a></li>
                <li><a href="http://diagnostika.medbooking.com/" target="_blank">Диагностические центры</a></li>
            </ul>
        </div>
    </div>
	<div class="bottom_inner_footer_block">
		<div class="copy">© Сopyright 2015. Все права защищены.</div>
	</div>-->
</footer>
</section>

</body>
</html>