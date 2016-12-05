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
	
	
	<title>Медицинская библиотека</title>
</head>
<body>
	<div id="wrapper">
		<header>
			<div id="logo_cont"><div id = "logo"></div></div>
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
			<div class="content_block" id="search_block">
				<form method="post">
					<div class="row">
						<div class="buttons">
							
								<input name="modelName" id="modelNameCont" type="hidden" value='clinics'/>
								<?php $modelName = 'clinics'; ?>
								<div modelName='doctors' class="mnchange doctors <?php echo $modelName == 'doctors' ? 'active' : ''; ?>">Доктора</div>
								<div modelName='clinics' class="mnchange clinics <?php echo $modelName == 'clinics' ? 'active' : ''; ?>">Клиники</div>
								<?php
									$cs -> registerScript('modelName_change','
										$(".mnchange").click(function(){
											$(".mnchange").removeClass("active");
											$(this).addClass("active");
											var modelName = $(this).attr("modelName");
											$("#search_speciality").attr("name",modelName + "SearchForm[speciality]");
											$("#search_metro").attr("name",modelName + "SearchForm[metro]");
											$("#modelNameCont").val(modelName);
										});
									',CClientScript::POS_END);
								?>
						</div>
						<div class="speciality_dropdown select">
							<div class="image"><span></span></div>
							<div class="select_cont">
								<?php $specialities = Filters::model() -> giveSpecialities(); ?>
								<?php echo CHtml::DropDownListChosen2('clinicsSearchForm[speciality]','search_speciality', $specialities,array(),array()); ?>
							</div>
						</div>
						<div class="metro_dropdown select">
							<div class="image"><span></span></div>
							<div class="select_cont">
								<?php
										$metro_obj = Metro::model()->findAll(array('order' => 'name ASC'));
								?>
								<?php echo CHtml::DropDownListChosen2('clinicsSearchForm[metro]','search_metro', CHtml::listData($metro_obj, 'id', 'name'),array(),array()); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<input type="submit" value="Найти" id="search_submit"/>
					</div>
					<div class="row adv_search">
						<a href="" class="advanced_search"><span>Расширенный поиск</span></a>
					</div>
				</form>
			</div>
			<div id="main_content content_block">
				
			</div>
		</section>
		<footer>
			
		</footer>
	</div>
</body>
</html>