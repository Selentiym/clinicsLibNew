<!DOCTYPE html>
<html class=" js no-touch">
<head>
	<!--[if lt IE 9]>
		<script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Cache-Control" content="no-cache"> <!-- Временный запрет кеширования. УБРАТЬ! -->

	<?php $cs = Yii::app()->getClientScript(); ?>
	<?php $cs -> registerCoreScript('jquery'); ?>
	<?php $cs -> registerCssFile(Yii::app()->baseUrl.'/css/index_new.css'); ?>
	<?php $cs -> registerCssFile(Yii::app()->baseUrl.'/css/common.css'); ?>
	
	<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/select2.min.css'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/select2.full.js'); ?>
	<?php
	$title = $this -> getPageTitle();
	$title = $title ? $title : Yii::app() -> name;
	?>
	
	<title>Медицинская библиотека</title>
</head>
<body>
	<div id="wrapper">
		<header>
			<div id="logo_cont"><a href="<?php echo Yii::app() -> baseUrl.'/'; ?>"><div id = "logo"></div></a></div>
			<div id="header_text">
				<div id="name">GOSCLINICA.RU</div>
				<div id="words">Информационный портал медицинских услуг</div>
				<div id="long_hedaer_text">
					Здесь вы найдете полную информацию о медицинских услугах государственных<br/>
					учреждений города: врачи, лаборатории, реабилитационные центры, диагностика...<br/>
					Рейтинги, отзывы пациентов и многое другое.<br/>
					GOSCLINICA.RU - Ваш компас на карте медицинских услуг!
				</div>
			</div>
			<div id="tel_cont">
				<div id="tel_bold">+0&nbsp(000)&nbsp000-00-00</div>
				<div id="work_hours">режим работы 8<span class="up">00</span>-21<span class="up">00</span></div>
			</div>
			<div id="search">
	<!--<div class="ya-site-form ya-site-form_inited_no right_inner_header_block right big" onclick="return {'action':'http://cq97848.tmweb.ru/search','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по ...','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2230691,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'Введите запрос','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}">-->
				<form class="header_search_form">
					<input type="hidden" name="searchid" value="2230691"/>
					<input type="hidden" name="l10n" value="ru"/>
					<input type="hidden" name="reqenc" value=""/>
					<input type="search" placeholder="Поиск" name="text" value=""/>
					<input type="submit" value=""/>
				</form>
			</div>
		</header>
		<section class="content">
			<div class="content_block" id="content_head_decor">
				<div>
					<div id="jaloba"><span>Жалоба/Симптом</span></div>
					<div id="diagn"><span>Диагностика</span></div>
					<div id="cure"><span>Лечение</span></div>
					<div id="reabil"><span>Реабилитация</span></div>
				</div>
			</div>
			<div id="main_content content_block">
				<?php echo $content; ?>
			</div>
		</section>
		<footer>
			
		</footer>
	</div>
</body>
</html>